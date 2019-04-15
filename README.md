CodeIgniter 3.1.10 + HMVC + debugbar


**Modif ROOTDIR --> public**
----------------------
1. di rootdir, buat direktori "public"
2. arahkan rootdir nginx / apache anda ke direktori "public"
3. pindahkan "index.php" (dan "user_guide" kalau diperlukan) ke "public"
4. edit "public/index.php", update:
		$system_path = '../system';
		$application_path = '../application';


**Helper GLOBAL**
--------------
Untuk mempermudah debugging, buat helper namanya "global_helper.php", simpan di folder "helpers", dan jadikan autoload.
Isi file-nya kurang lebih seperti ini:
```
<?phpCodeIgniter 3.1.10 + HMVC + debugbar
---

<h3>Modify ROOT DIRECTORY</h3>

Let's make a little modification here :-)

1. create directory <code>public</code> at rootdir (if not exist yet!), so it should look like this:
   ```
   project_dir/
     +---  application/
     +---  public/
     +---  system/
     +---  user_guide/
     +---  vendor/
     composer.json
     index.php
     ```
1. point your webserver (nginx / apache) rootdir to that "public" directory
1. move <code>index.php</code> (and <code>user_guide</code> _if only_ you still need it) to <code>public</code> _newly_ created.
	```
   project_dir/
     +---  application/
     +---  public/
            +---  user_guide/
            index.php
     +---  system/
     +---  vendor/
     composer.json
     ```
1. edit <code>index.php</code>, update <code>$system_path</code> and <code>$application_path</code> into these:
```php
$system_path = '../system';
$application_path = '../application';
```
**Note:**
Since the webserver rootdir pointed to <code>public</code> directory, you should put all html assets in it, such as CSS, JS, Images, etc.

------

<h3>A Little "Helper"</h3>

To make debugging _easier_:
1. Create a new helper file called: _<code>global_helper.php</code>_ under _<code>application/helpers</code>_, look like this (modify as you like):
```php
<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

function debugz($data = NULL, $pre = TRUE) 
{
	if($pre) { echo '<pre>'; }
	print_r($data);
	if($pre) { echo '</pre>'; }	
	die();
}

function dumpz($data = NULL, $pre = TRUE) 
{
	if($pre) { echo '<pre>'; }
	var_dump($data);
	if($pre) { echo '</pre>'; }	
	die();
}
```
2. Make it _autoload_ in the _config/autoload.php_ by doing this:
```php
$autoload['helper'] = array('global');
```



**Helper Usage:**

<code>**debugz(_$var_)**</code>
will do a simple <code>print_r($var)</code> inside ```<pre>...</pre>``` tag and then <code>**die()**</code>, so it will stop the next process.

<code>**debugz(_$var, FALSE_)**</code>
will do the same, without ```<pre>...</pre>```

<code>**dumpz(_$var_)**</code>
will do <code>var_dump($var)</code> inside ```<pre>...</pre>``` tag and then <code>**die()**</code>, so it will stop the next process.

<code>**dumpz(_$var, FALSE_)**</code>
will do the same, without  ```<pre>...</pre>```






**Fitur DEBUGBAR**
---------------
https://github.com/Tan5en5/codeigniter-debugbar


1. edit /composer.json:
   - edit baris: "require-dev.mikey179/vfsStream" menjadi: "require-dev.mikey179/vfsstream" (huruf kecil semua)
   - hapus baris "phpunit/phpunit-mock-objects" karena sudah deprecated / tidak ada
   - pada bagian "require", tambahkan "tan5en5/codeigniter-debugbar": "dev-master", lengkapnya seperti ini:
   =====================================================
	{
		"require": {
			"tan5en5/codeigniter-debugbar": "dev-master"
		}
	}
	=====================================================
	- save, exit
	- jalankan "composer update", pastikan tidak ada error.

2. Enable-kan composer autoload (di file "application/config/config.php"), pastikan tambahkan baris ini :
	"$config['composer_autoload'] = realpath(APPPATH.'../vendor/autoload.php');"

3. Enable-kan package Debugbar (di file "application/config/autoload.php"), tambahkan baris ini :
	"$autoload['packages'] = array(APPPATH.'third_party/codeigniter-debugbar');"

4. sejauh ini debugbar sudah berjalan




**Enable HMVC**
https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/downloads/

1. Download modul CI HMVC di: https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/get/f77a3fc9a6fd.zip dan ekstrak!
2. Dari hasil ekstrak:
   * kopi isi 'core/' ke dalam 'applications/core/'
   * kopi folder 'third-party/MX' ke 'application/third-party/'
3. Di dalam folder 'application', buat folder baru namanya 'modules' (contoh: 'application/modules'). Didalam folder modules itulah kita akan membuat modul-modul HMVC
4. Buka 'application/config/config.php', tambahkan:
	```
	/* Modul HMVC */
$config['modules_locations'] = array(
    APPPATH . 'modules/' => '../modules/',
    // modul lain 1,
    // modul lain 2.. 3.. dst kalau ada mah!
);
	```
5. klo ada error, lihat di bagian bawah!




https://www.aviantorichad.com/2019/01/solved-error-strpos-pada-hmvc-ci-php-7.3.html






**<h2>ERROR ROUTER</h2>**

A PHP Error was encountered
Severity: 8192

Message: strpos(): Non-string needles will be interpreted as strings in the future. Use an explicit chr() call to preserve the current behavior

Filename: MX/Router.php

Line Number: 239
-----------------------

INI PERBAIKANNYA 

Buka application/third-party/MX/Router.php
GANTI FUNGSI ```function set_class($class)``` menjadi seperti ini (full):
------------------------------------------------------------------------------------------
```
	public function set_class($class)
	{
		$suffix = $this->config->item('controller_suffix');
		if ($suffix && strpos($class, $suffix) === FALSE)
		{
			$class .= $suffix;
		}
		parent::set_class($class);
	}
```
------------------------------------------------------------------------------------------



**<h2>ERROR LOADER</h2>**
```
An uncaught Exception was encountered
Type: Error

Message: Call to undefined method MY_Loader::_ci_object_to_array()

Filename: /Volumes/data/DOMAINS/htdocs/CodeIgniter/ci3110_blank/application/third_party/MX/Loader.php

Line Number: 300
```
-----------------------

INI PERBAIKANNYA 

Buka application/third-party/MX/Loader.php
CARI apakah ada fungsi ```_ci_object_to_array()```
PASTIKAN ADA, DAN ISINYA HARUS SEPERTI INI:
------------------------------------------------------------------------------------------
```
protected function _ci_object_to_array($object) {
		return is_object($object) ? get_object_vars($object) : $object;
	}
```
------------------------------------------------------------------------------------------

