# laravel-insights-system
This idea is a portal, as if it were a forum, where I have three types of access (Administrator, Writer and Client). Where the Administrator manages the other profiles, the writer adds the publications, the Client views them.

Initially, the client will log on to the platform and on the home page will have graphics with information collected by the publication posted by the Writer, for their specific profile, I say this because some posts may be for certain Clients and others may not, so the Writer must be able select which customer or customer group should receive the post.

The posts are related to cyber threats, for example a vulnerability in a system used by healthcare operators. The Writer will have his panel to fill in data specifically related to the topic of "vulnerability" and will complete this publication, selecting which customers will receive the view on his Dashboard portal and also via email.

There are about 10 topics for publication (including vulnerabilities) the Administrator must be able to create groups of Clients, and create specific forms for new publications of different themes.

## Screenshots


## Get Started
env setting

Composer install
```sh
$ composer install
```

Laravel license
```sh
$ php artisan key:generate
```

Database migrate and seed
```sh
$ php artisan migrate --seed
```

Storage link
```sh
$ php artisan storage:link
```

Run serve
```sh
$ php artisan serve
```
