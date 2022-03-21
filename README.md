# RockSkinUikit

## A message to Russian 🇷🇺 people

If you currently live in Russia, please read [this message](https://github.com/Roave/SecurityAdvisories/blob/latest/ToRussianPeople.md).

[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

---

Just install the module and you can change the look&feel of your admin instantly by changing only one color:

![less](https://i.imgur.com/t2Sgpyg.png)

![demo-theme](https://i.imgur.com/XYp0SBQ.png)

[Demo-Video on YouTube](https://www.youtube.com/watch?v=GQlFV6DJT8I)

## Create LESS file

RockSkinUikit will look for the less file in `/site/assets/RockSkinUikit/theme.less`.

## Using LESS variables

You can modify LESS variables from PHP by setting the `$config->lessVars` array:

```php
$config->lessVars = [
  'tm-primary' => '#146dbf',
];
```
