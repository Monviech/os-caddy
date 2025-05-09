# Important Information

**www/caddy is now included in OPNsense plugins.**

https://github.com/opnsense/plugins/tree/master/www/caddy

https://docs.opnsense.org/manual/how-tos/caddy.html

**www/xcaddy is for development purposes and not included in OPNsense plugins.**

To use it, you have to build the plugin and install it.

Afterwards you need lang/go and www/xcaddy from freebsd or opnsense ports. Best build them from source with ```make install clean```.

Warning: Do not use in production on a firewall as having a language like go installed there can be a potential security concern, this is for development only.
