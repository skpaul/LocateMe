# LocateMe (Beta)
Find used or unused image, javascript, css or any other files within your application.



## Installation

Download the repository. Unzip it. You shall get three files-

1. locate_a.php
2. locate_b.php
3. locate_c.php

Move all the files to your application root.



## How to find

Open the file-

```html
http://localhost/your_app/locate_a.php
OR,
http://localhost/your_app/locate_b.php
OR,
http://localhost/your_app/locate_c.php
```

Then, write your search criteria in the textbox.

That's all.



## locate_a.php

It finds a single file in all other files within your application.

For example, **old_logo.png**

locate_a.php will find the text **old_logo.png** in all files of your application.



## locate_b.php

It finds multiple files which are **used** in other files.

You specify the directory for the files you want to search for.

For example, **./images** will list all the files from images folder, and find those in other files.



## locate_c.php

It finds multiple files which are **not used** in other files.

You specify the directory for the files you want to search for.

For example, **./images** will list all the files from images folder, and find those in other files.