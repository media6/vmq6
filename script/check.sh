cd /home/sources/www/vmq.media6.ca/script/
rm postfix.log
tail -100 /var/log/mail.log > postfix.log
php check.php



