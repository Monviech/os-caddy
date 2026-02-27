# Important Information

**www/caddy is included in OPNsense plugins**

https://github.com/opnsense/plugins/tree/master/www/caddy

This repository contains a fork of it which retains the DNS Provider subsystem, and adds a helper xcaddy plugin so the binary can be easily upgraded to include
whichever module is needed.

- os-caddy-plus 2.1.0 requires OPNsense version 26.1 or later
- os-xcaddy-plus 0.2 requires OPNsense version 25.1 or later

**How to install on OPNsense:**

- Ensure you have removed the packages ``os-caddy`` and ``caddy-custom`` (served from the OPNsense repository).
- Existing configuration of ``os-caddy`` will be compatible with ``os-caddy-plus``, yet not necessarily the other way around.

1.    ``pkg install git``
2.    ``mkdir -p /src/git``
3.    ``cd /src/git``
4.    ``git clone https://github.com/opnsense/ports``
5.    ``git clone https://github.com/Monviech/os-caddy``
6.    ``cd /src/git/ports/lang/go``
7.    ``make -DBATCH install clean``
8.    ``cd /src/git/ports/www/caddy``
9.    ``make -DBATCH install clean``
10.   ``cd /src/git/ports/www/xcaddy``
11.   ``make -DBATCH install clean``
12.   ``cd /src/git/os-caddy/www/caddy-plus``
13.   ``make package``
14.   ``cd /src/git/os-caddy/www/caddy-plus/work/pkg``
15.   ``pkg install *.pkg``
16.   ``cd /src/git/os-caddy/www/xcaddy-plus``
17.   ``make package``
18.   ``cd /src/git/os-caddy/www/xcaddy-plus/work/pkg``
19.   ``pkg install *.pkg``

- Now everything should be installed.

**How to use os-xcaddy-plus:**

You can find the xcaddy plugin in ``Services: Caddy: Modules``:

  -  Press ``Update Modules``, this automatically pulls all available plugins for caddy
  -  Select the base build with the ``Modules`` dropdown, to use all features you need at least:


    github.com/mholt/caddy-dynamicdns
    github.com/mholt/caddy-l4
    github.com/caddy-dns/cloudflare   <- A DNS Provider of your choice

   
  - Press ``Build`` and wait until the build has finished
  - To keep caddy automatically up to date, create a cronjob:

     - ``System: Settings: Cron`` that calls ``Build Caddy binary with additional modules``
  - Service restarts are handled automatically if a build succeeds
  - Afterwards you can use ``os-caddy-plus`` with the binary you just built.

**How to use os-caddy-plus:**

https://docs.opnsense.org/manual/how-tos/caddy.html
