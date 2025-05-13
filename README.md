<p align="center">On The Map Wordpress starter</p>

## Server requirements

* Your document root must be configurable (_most_ local development tools and webhosts should support this)
* PHP >= 8.0 with the following extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, Tokenizer, XML
* Composer
* WP-CLI

If you are using a managed WordPress host, make sure that they meet these requirements if you're wanting to deploy your Radicle projects to them.

### ACF Pro Setup
Create a file called `auth.json`. Add the following to the file:
```json
{
  "http-basic": {
    "connect.advancedcustomfields.com": {
      "username": "API_KEY",
      "password": "SITE_URL"
    }
  }
}
```
Credentials can be found in the [ACF account page](https://www.advancedcustomfields.com/my-account/).

### Local development

<details>
  <summary>⚙️ Valet</summary>
  <br>

  1. Run `yarn && yarn build`
  1. Run `composer install`
  1. Configure your local development setup to set the `public/` directory as the webroot. (Valet usually does it automatically)
  1. Copy `.env.example` to `.env` and update the [environment variables](https://roots.io/bedrock/docs/installation/#getting-started)
  1. Install WordPress with `wp core install --title="Site Name" --admin_user="otmseo" --admin_password="8nest79SuMTa(YzGP0" --admin_email="dev@onthemap.com" --url="https://sitename.test"`

</details>

### Deploying Radicle
<details>
  <summary>⚙️ Wordmove</summary>
  <br>

  WIP

</details>

## Places to be

| Path                            | Description                   |
|---------------------------------|-------------------------------|
| `config/post-types.php`         | Post types configuration      |
| `config/theme.php`              | Theme setup configuration     |
| `public/content/`               | `wp-content` directory        |
| `storage/logs/application.log`  | App log                       |
| `resources/scripts/editor/`     | Block editor related scripts  |
| `resources/views/`              | Theme templates               |

## Additional Packages

| Package                                   | Description                                                           |
|-------------------------------------------|-----------------------------------------------------------------------|
[log1x/crumb](https://github.com/Log1x/crumb)                             | Breadcrumb trail for WordPress                                        |
[log1x/navi](https://github.com/Log1x/navi)                              | A lightweight, developer-friendly WordPress navigation helper         |
[log1x/acf-compoer](https://github.com/Log1x/acf-composer)               | A Composer installer for Advanced Custom Fields Pro                   |
