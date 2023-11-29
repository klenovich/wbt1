#!/bin/bash

#find app admin install system config storage/compiled-templates -name '*.*' > POTFILES
find . -not -path "*/node_modules/*" -not -path "*/storage/*" -not -path "*/vendor/*" -not -path "*/src/*"  -not -path "*/libs/*" -not -path "*/sections/*" -type f \( -iname \*.php -o -iname \*.html \)  > POTFILES
php gettext-html.php
xgettext --from-code=UTF-8  --no-wrap --omit-header --copyright-holder=Vvveb --package-name=Vvveb --lang=ro_RO -LPHP --keyword='__' --keyword='\Vvveb\__'  --files-from=POTFILES -o locale/ro_RO/LC_MESSAGES/vvveb.pot
msgmerge -U --no-wrap --lang=ro_RO locale/ro_RO/LC_MESSAGES/vvveb.po locale/ro_RO/LC_MESSAGES/vvveb.pot
#msgmerge -U  --lang=ro_RO locale/ro_RO/LC_MESSAGES/vvveb.pot~ locale/ro_RO/LC_MESSAGES/vvveb.po
msgfmt -o locale/ro_RO/LC_MESSAGES/vvveb.mo locale/ro_RO/LC_MESSAGES/vvveb.po
#rm POTFILES
