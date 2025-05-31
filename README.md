# Important Information

**www/caddy is included in OPNsense plugins**

https://github.com/opnsense/plugins/tree/master/www/caddy

This repository contains a fork of it which retains the DNS Provider subsystem, and adds a helper xcaddy plugin so the binary can be easily upgraded to include
whichever module is needed.

**DISCLAIMER:**

Do not use ``os-xcaddy-plus`` in a production environment. A language dependency like ``lang/go`` can be a potential security concern. **Consider this plugin for development only.**

**How to install on OPNsense:**

- Ensure you have removed the packages ``os-caddy`` and ``caddy-custom`` (served from the OPNsense repository).
- Existing configuration of ``os-caddy`` will be compatible with ``os-caddy-plus``, yet not necessarily the other way around.

- Clone https://github.com/opnsense/ports
  - Move into the cloned repository
  - Go to ``./lang/go`` and ``make install``
  - Go to ``./www/caddy`` and ``make install``
  - Go to ``./www/xcaddy`` and ``make install``
- Clone https://github.com/Monviech/os-caddy
  - Move into the cloned repository
  - Go to ``./www/caddy-plus`` and ``make package``
    -  Go to ``./www/caddy-plus/work/pkg`` and ``pkg install *.pkg``
  - Go to ``./www/xcaddy-plus`` and ``make package``
    -  Go to ``./www/xcaddy-plus/work/pkg`` and ``pkg install *.pkg``

- Now everything should be installed.

**How to use os-xcaddy-plus:**

You can find the xcaddy plugin in "Services: Caddy: Modules":

  -  Press ``Update Modules``, this automatically pulls all available plugins for caddy
  -  Select the base build with the ``Modules`` dropdown, to use all features you need at least:


    github.com/caddyserver/ntlm-transport 
    github.com/mholt/caddy-dynamicdns
    github.com/mholt/caddy-l4
    github.com/caddy-dns/cloudflare   <- A DNS Provider of your choice

   
  - Press ``Build`` and wait until the build has finished
  - To keep caddy automatically up to date, create a cronjob:

     - "System: Settings: Cron" that calls ``Build Caddy binary with additional modules``
  - Service restarts are handled automatically if a build succeeds
  - Afterwards you can use the ``os-caddy-plus`` plugin as you wish

**How to use os-caddy-plus:**

https://docs.opnsense.org/manual/how-tos/caddy.html
