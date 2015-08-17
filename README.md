# Digest Trigger

Allows DokuWiki's pending digests to be sent without waiting for any kind of access.

You can find the latest version of this plugin at:

	https://github.com/abiliojr/digesttrigger

# Use

This plugin is meant to be executed from command line, from within the php server user.
Try something like:

    sudo -u www-data php digest.php

You can also run it from within www-data cron, like:

    0 9/13 * * * /usr/bin/php /var/www/dokuwiki/lib/plugins/digesttrigger/digest.php -c

Note: the user name and paths may vary.

Ideas, suggestions, bug reports and help are welcomed! Please go to:

	https://github.com/abiliojr/digesttrigger

And contact me through the issues section.

If you install this plugin manually, make sure it is installed in
lib/plugins/digesttrigger/ - if the directory is called different it
will not work!

Please refer to http://www.dokuwiki.org/plugins for additional info
on how to install plugins in DokuWiki.

----
Copyright (C) Abilio Marques <https://github.com/abiliojr>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 2 of the License

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

See the LICENSE file for details