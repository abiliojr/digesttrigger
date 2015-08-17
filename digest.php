<?php

/**
 * Use this tool to massively send all the pending subscription digests without waiting
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Abilio Marques <https://github.com/abiliojr>
 */

if(!defined('DOKU_ROOT')) define('DOKU_ROOT', realpath(dirname(__FILE__).'/../../../').'/');
define('NOSESSION', 1);

require_once(DOKU_ROOT.'inc/init.php');


class DigestTriggerCLI extends DokuCLI {
    /**
     * Register options and arguments on the given $options object
     *
     * @param DokuCLI_Options $options
     * @return void
     */
    protected function setup(DokuCLI_Options $options) {
		global $auth;
		global $conf;

		$auth = new auth_plugin_authplain();
		$period = $conf['subscribe_time'];

        $options->setHelp(
            "Massively sends pending subscription digests.\n" .
            "By default, sends every pending digest from the beginning of time. " .
            "An event must be older than \$conf['subscribe_time'] = $period sec " .
            "to be included in any digest."
        );

        $options->registerOption(
            'cron',
            "Send all the pending emails aged between $period and " .
            2 * $period . " seconds. Useful to be run from a cron scheduler.",
            'c'
        );
    }

	protected function findFreshEdits($betweenPeriod) {
		global $conf;
		global $auth;

		// use 0.95 and 1.1 to be sure it sends everything even with cron jitter
		$timestampHigh = time() - 0.95 * $conf['subscribe_time'];
		$timestampLow = $timestampHigh - 1.1 * $conf['subscribe_time'];
		if (!$betweenPeriod) $timestampLow = 0;
		$changesFile = $conf['changelog'];
		return explode("\n", shell_exec("cat $changesFile | grep [[:blank:]][Ee][[:blank:]] | cut -f 1,4 | awk '\$1>=$timestampLow && \$1<=$timestampHigh' | cut -f 2 | sort | uniq"));
	}

	protected function sendAll($IDs) {
		$sub = new Subscription();

		foreach($IDs as $ID) {
			if (!$ID) continue;
			echo "$ID sent to " . $sub->send_bulk($ID) . " email(s)\n";
		}	
	}

    /**
     * Your main program
     *
     * Arguments and options have been parsed when this is run
     *
     * @param DokuCLI_Options $options
     * @return void
     */
    protected function main(DokuCLI_Options $options) {
        $cron = $options->getOpt('cron');
        $this->sendAll($this->findFreshEdits($cron));
    }
}

// Main
$cli = new DigestTriggerCLI();
$cli->run();