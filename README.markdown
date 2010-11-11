Dev Environment
/etc/hosts
127.0.0.1	mentaway.dev

httpd.conf
NameVirtualHost 127.0.0.1

<VirtualHost yourdomain.dev>
	ServerName mentaway.dev
	DocumentRoot "/Users/eduardosasso/Sites/mentaway"
</VirtualHost>