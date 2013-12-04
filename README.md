- Clone this repo
- Get WordPress

```
git clone https://github.com/WordPress/WordPress.git public
cd public
git checkout 3.7.1
cd ..
```

- Install WP
- Put the wp-config one level higher (root of this repo)

```
mv public/wp-config.php .
```

- Change it to this at the end:

```
// some globals WP needs (e.g. plugins)
include_once __DIR__ . '/bootstrap.php';

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
```

Now your themes and plugins folder is outside of WordPress and can be
under version control without having the whole of WP in it.
You can even use submodules for the plugins to have a slim repo and be
up to date within  a single `git submodule foreach git pull`.
