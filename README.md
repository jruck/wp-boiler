#### Welcome to your new WordPress site, based on wp-boiler

*Once you create your new site, feel free to replace this Readme with your own, or just append your info here.*

====================

## About wp-boiler

This is a Git-friendly foundation and workflow for quickly creating and managing new WordPress sites, assembled by [Justin Ruckman](http://jruck.us) of [Priceless Misc](http://pricelessmisc.com), and heavily derivative of Mark Jarquith's [WordPress Skeleton](https://github.com/markjaquith/WordPress-Skeleton).

It includes a copy of the Twenty Twelve theme for use as a control variable and emergency fallback during development and testing, plus a handful of commonly-installed plugins:

*  **Akismet** - for spam
* **All-In-One SEO Pack** - for tweaking page titles/descriptions as displayed on search engines, regardless of theme used
* **EWWW Image Optimizer** - for automatically optimizing images beyond what WordPress does internally (good for faster speed and high GTMetrix, YSlow, etc scores)
* **GTMetrix for WordPress** - for optimizing and monitoring site performance, includes built-in support for managing CloudFlare
* **Hide Update Reminder Message** - for disabling the constant update reminders, useful when handing sites over to clients so they aren't bothered by upgrade alerts, or tempted to upgrade without consulting with you first
* **W3 Total Cache** - for, like, caching
* **WP Typography** - for automatically applying proper em dashes, smart quotes, elipses, etc.

A default database is available upon request with a number of baseline configurations.

I'll update the WordPress version when I feel it's ready for production. Included plugins will also be updated, and from time to time,  likely swapped out alltogether.

## Features

1. The core WordPress code is a Git submodule, and references [the official WordPress repo on Github](https://github.com/WordPress/WordPress). It lives in `/wp/` for easy management away from your custom content, and can be updated via Git, separate from your main project, by checking out the desired release tag straight from WordPress.
2. The `/content/` directory in the root overrides the default `/wp-content/` folder.
3. A `local-config-sample.php` file which you can use to create a `local-config.php`. This file will be ignored by Git, and any settings specificed will automatically override the corresponding settings in the default `wp-config.php`, allowing you to maintain separate configurations on your development and production environments.

## Starting a new project w/ wp-boiler

1.	Create a new repo on your hosting service of choice (Github, Bitbucket, etc) with your `NEW_PROJECT_NAME`



2.	On your local machine, in the directory where you keep your code, execute the following, replacing `NEW_PROJECT_NAME` w/ your desired destination folder:

		git clone --recursive --origin wp-boiler --depth 1 git@github.com:pricelessmisc/wp-boiler.git NEW_PROJECT_NAME
	
	*`--recursive` forces it to pull the linked WordPress submodule down in addition to the main repo, `--origin wp-boiler` renames `origin` to `wp-boiler` to keep `origin` free for your own use (and give you the flexibility to pull changes from `wp-boiler` in the future if you like), and `--depth 1` makes sure you're just adding the most recent commit of this framework to your new project, keeping it free of this project's revision history.*

3.	`cd NEW_PROJECT_NAME`

4.	`git remote add origin ssh://you@yourhost.com/usernname/NEW_PROJECT_NAME.git`

5.	`git rebase --root`
	
	*This resets your `HEAD` to its current position, basically telling your new Git repo to forget about its past life before it came to you, except for the details that matter, like what files to ignore, and where to fetch new WordPress submodule updates from.*

6.	`git push --set-upstream origin master`
	
	*This sends your new repo to your hosting service, and sets it to track your host as its origin master.*

## Starting a new project w/ wp-boiler the easy way

1.	Create a Git alias like this:

		wp = "!f() { git clone --recursive --origin source --depth 1 git@github.com:pricelessmisc/wp-boiler.git $1 && cd $1 && git remote add origin ssh://YOU@YOUR_HOST.COM/YOUR_USER/$1.git && git rebase --root && git push --set-upstream origin master; }; f"

2.	Make sure you already have a new repo setup with your `NEW_PROJECT_NAME` on your hosting service of choice (Github, Bitbucket, etc)

3.	Enter `git wp NEW_PROJECT_NAME` and let the magic happen	 

## Credits & usage

I made this for myself, and for my developers at [Priceless Misc](http://pricelessmisc.com), to simplify the process of creating and managing new WordPress sites via Git. Feel free to use this however you like, and keep me updated if you make any cool changes.