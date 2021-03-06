# 3RD PARTY LICENSES

Ora et Labora makes use of 3rd party code for some of its functionalities. Here, we would like to list them and express our gratitude to all those projects that helped *Ora et Labora* to become what it is today.

### Bootstrap
**Webpage:**: https://getbootstrap.com/
**License**: [MIT License](https://github.com/twbs/bootstrap/blob/v4.0.0/LICENSE)

### JQuery
**Webpage:**: https://jquery.com/
**License**: [MIT License](https://github.com/jquery/jquery/blob/master/LICENSE.txt)



### Composer
**Webpage:**: https://getcomposer.org/
**License**: [MIT License](https://github.com/composer/composer/blob/master/LICENSE)


### PHPMailer
**Webpage:**: https://github.com/PHPMailer/PHPMailer
**License**: [GNU Lesser General Public License v2.1](https://github.com/PHPMailer/PHPMailer/blob/master/LICENSE)
**Additional information**: As part of the LGPL 2.1 License, we would like to state that any user is free to modify/substitute the portion of our code that involves the use of PHPMailer (as they are to modify any other part of our code).  

PHPMailer is only used when a player asks for a new password. This functionality is included in `public/src/front/forgotten_pass.php`, which should be rewritten entirely if the reader wants to substitute this library for a different one. Our `composer.json` file might also include a reference to PHPMailer.

