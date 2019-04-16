<h3>CodeIgniter 3.1.10 + HMVC + debugbar</h3>

---
<h4>Credits:</h4>

_**CodeIgniter**_
https://codeigniter.com/

_**HMVC Modular Extension: WireDesignZ**_
https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc

_**CodeIgniter Debugbar: Tan5en5**_
https://github.com/Tan5en5/codeigniter-debugbar

---

<h3>First thing first:</h3>

untuk menginstal / update ```vendor```, eksekusi:
```sh
composer update
```


<h3>Sedikit modifikasi: apache htdocs / nginx root dir</h3>
----------------------
1. Arahkan htdocs webserver anda ke direktori ```public```
2. Pindahkan ```index.php```, ```user_guide``` (_kalau masih dibutuhkan_) ke dalam direktori ```public```
3. Edit ```public/index.php```, update 2 baris ini:
		$system_path = '../system';
		$application_path = '../application';

_**Note:**_
Karena htdocs / root dir webserver diarahkan ke direktori <code>public</code>, maka semua aset html seperti CSS, JS, Images dan lain-lain harus disimpan didalam direktori <code>public</code> tersebut.


<h3>Helper: _global_</h3>
--------------
Untuk mempermudah _debugging_, telah dibuat helper namanya "global_helper.php". Disimpan di folder ```helpers```, dan jadikan autoload.

Fungsi dari helper global ini, antara lain:

1. <code>debugz($var)</code>
	ini akan melakukan ```print_r($var)``` kemudian ```die()```  didalam tag html ```<pre>...</pre>```

2. <code>debugz($var, FALSE)</code>
	sama dengan <code>debugz($var)</code>, tapi tanpa ```<pre>...</pre>```

3. <code>dumpz($var)</code>
	ini akan melakukan ```print_r($var)``` kemudian ```die()```  didalam tag html ```<pre>...</pre>```

4. <code>dumpz($var, FALSE)</code>
	sama dengan <code>dumpz($var)</code>, tapi tanpa ```<pre>...</pre>```

5. <code>debugbar()</code>
	untuk mengaktifkan debugbar, tinggal masukan baris <code>debugbar()></code>, baik di controller maupun di views.

---

<h2>Merakit dari NOL</h2>

Tentunya, **download CodeIgniter** terbaru (saya menggunakan versi 3.1.10). Mari membuat sedikit modifikasi :-)

1. Jika belum ada, buat direktori <code>public</code> sejajar dengan direktori <code>application</code> dan <code>system</code>.
2. Kemudian pindahkan <code>index.php</code> beserta <code>user_guide</code> kedalam <code>public</code> tersebut.
Struktur baru seharusnya menjadi seperti berikut:
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
3. Edit <code>index.php</code>, update <code>$system_path</code> and <code>$application_path</code> menjadi seperti ini:
```php
$system_path = '../system';
$application_path = '../application';
```
Ok, _1st_ step: Done!
Jangan lupa arahkan htdocs / root dir web server anda ke direktori <code>public</code>


Berikutnya, **instalasi _codeigniter-debugbar_** via _composer_. Buka <code>composer.json</code> dan edit seperti berikut: 

1. Edit baris: "require-dev.mikey179/vfsStream" menjadi: "require-dev.mikey179/vfsstream" (huruf kecil semua)
2. Hapus baris "phpunit/phpunit-mock-objects" karena sudah _deprecated_
3. Pada bagian _"require"_, tambahkan _"tan5en5/codeigniter-debugbar": "dev-master"_, lengkapnya seperti ini:
```php
{
	"require": {
		"tan5en5/codeigniter-debugbar": "dev-master"
	}
}
```
4. Save + exit, kemudian jalankan <code>composer update</code>. Pastikan tidak ada error.
5. Enable-kan _composer_autoload_ di file _"application/config/config.php"_, tambahkan baris ini :
```php
$config['composer_autoload'] = realpath(APPPATH.'../vendor/autoload.php');
```
6. Enable-kan package _codeigniter-debugbar_ di file _"application/config/autoload.php"_, tambahkan baris ini :
```php
$autoload['packages'] = array(APPPATH.'third_party/codeigniter-debugbar');
```
7. Sejauh ini debugbar seharusnya sudah dapat dipakai.

Agar mempermudah pemanggilan _debugbar_ ini, Saya pribadi membuat fungsi dalam sebuah helper (namanya _global_helper.php_)yang di-autoload. Isinya kurang lebih seperti ini:
```php
function debugbar()
{
   $ci =& get_instance();
   $ci->load->library('console');
   // $this->console->exception(new Exception('test exception'));
   $ci->console->debug('Debug message');
   $ci->console->info('Info message');
   $ci->console->warning('Warning message');
   $ci->console->error('Error message');
   $ci->output->enable_profiler(TRUE);
   //return;
}
```
Pemanggilannya bisa dilakukan baik di controller maupun di view-nya langsung, hanya dengan memasukan baris <code>debugbar();</code>

Untuk setting lebih lengkapnya silakan baca-baca sendiri dokumentasinya di website pemiliknya.

Berikutnya, _**instalasi Modul Ekstensi HMVC**_, dari _WireDesignZ_ 

1. Download modul CI HMVC di: https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/get/f77a3fc9a6fd.zip dan ekstrak!
2. Dari hasil ekstrak:
   * kopi semua isi ```core/``` ke dalam ```applications/core/``` (biasanya cuma ada 2 file: _MY_Router.php_ dan _MY_Loader.php_)
   * kopi folder ```third-party/MX``` ke ```application/third-party/MX```
3. Buat direktori baru namanya '_application/modules_'. Didalam itulah kita akan membuat modul-modul HMVC.
4. Buka '_application/config/config.php_', tambahkan:
```php
/* Modul HMVC */
$config['modules_locations'] = array(APPPATH . 'modules/' => '../modules/');
```
5. klo ada error, scroll di bagian penjelasan error-error di bagian bawah!

Sampai tahap ini, HMVC dan debugbar seharusnya sudah dapat berjalan. 

---
<h2>ERROR(s)</h2>

**Error ROUTER**

> A PHP Error was encountered
Severity: 8192
>
>Message: strpos(): Non-string needles will be interpreted as strings in the future. Use an explicit chr() call to preserve the current behavior
>
>Filename: MX/Router.php
>
>Line Number: 239

Ini perbaikannya:

1. Buka _application/third-party/MX/Router.php_
2. Cari baris: <code>function set_class($class)</code> dan ubah menjadi seperti ini (full):
```php
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
Sumber:
https://www.aviantorichad.com/2019/01/solved-error-strpos-pada-hmvc-ci-php-7.3.html


**Error LOADER**

>An uncaught Exception was encountered
>Type: Error
>
>Message: Call to undefined method MY_Loader::_ci_object_to_array()
>
>Filename: >/Volumes/data/DOMAINS/htdocs/CodeIgniter/ci3110_blank/application/third_party/MX/Loader.php
>
>Line Number: 300

Ini perbaikannya:

1. Buka _application/third-party/MX/Loader.php_
2. Cari fungsi <code>_ci_object_to_array()</code>. Jika tidak ada, buat dan isinya pastikan seperti ini:
```php
protected function _ci_object_to_array($object) {
		return is_object($object) ? get_object_vars($object) : $object;
	}
```
---
