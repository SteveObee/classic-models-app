## About the app

The classic models app is built with the php framework [laravel](https://laravel.com) and utilizes a MySQL database found [here](https://www.mysqltutorial.org/getting-started-with-mysql/mysql-sample-database/). It was created to demonstrate my capabilities as a web developer and become a cornerstone of my portfolio, hosted on my personal [website](https://steveobee.github.io/) and deployed at http://classic-models-app.dependabledev.co.uk

The scenario imagines being approached by a retailer looking to expand online with an existing database containing records associated with company operations. Here is a description of the database from the mysqltutorial website.

>"The classicmodels database is a retailer of scale models of classic cars. It contains typical business data, including information about customers, products, sales orders, sales order line items, and more."

### The process

The project is set up using [Laravel Jetstream](https://jetstream.laravel.com/introduction.html), which takes care of the auth and login process among other things and [InertiaJs](https://inertiajs.com/) for SSR, coupled with [VueJs](https://vuejs.org/) for the frontend.

The app has been developed with a strong Domain Driven Design influence and incorporates a lot of the aspects I have learnt from [Martin Joo](https://martinjoo.dev/blog) and his wonderful blog. Check out the /src folder to see some of my implementations of Martin's teachings.

### Images

All images are sourced from [pexels.com](https://www.pexels.com/) and are randomly assigned to products by product lines related to pexel collection's. These collections are setup in my pexels account and a PEXELS_API_KEY in the .env file allows the app access to those collections.

This means in order to replicate this capability you would need to first have your own PEXELS_API_KEY for the .env file then create your own collections on pexels before editing the database/seeders/productlineSeeder file to link pexel collection id's and product lines.

After all that a command run after database migration and seeding will gather all products and download the related pictures from pexels to app storage in the size given.

`php artisan image:store-images {size}`

At the moment the site only requires tiny and medium size pictures although that may change in the future.

### Closing

The project taught me a great deal about DDD principles and patterns and significantly improved my ability to architect and build a robust, adaptable and responsive web app.

I hope the source code may be of use to you 👋.


