<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Js;
use Illuminate\Support\Str;

class FileStorageLearnController extends Controller
{
    protected const berhasil = 'text-bg-success';
    protected const gagal = 'text-bg-danger';

    protected static function boolean_to_string(bool $condition, string $value_true, string $value_false): array {
        return ($condition) ? [$value_true, self::berhasil] : [$value_false, self::gagal];
    }

    protected static function formatted_file_permission($perms) {
        switch ($perms & 0xF000) {
            case 0xC000: // socket
                $info = 's';
                break;
            case 0xA000: // symbolic link
                $info = 'l';
                break;
            case 0x8000: // regular file
                $info = '-';
                break;
            case 0x6000: // block special
                $info = 'b';
                break;
            case 0x4000: // directory
                $info = 'd';
                break;
            case 0x2000: // character special
                $info = 'c';
                break;
            case 0x1000: // FIFO pipe
                $info = 'p';
                break;
            default: // unknown
                $info = 'u';
        }
        
        // Owner
        $info .= (($perms & 0x0100) ? 'r' : '-');
        $info .= (($perms & 0x0080) ? 'w' : '-');
        $info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));
        
        // Group
        $info .= (($perms & 0x0020) ? 'r' : '-');
        $info .= (($perms & 0x0010) ? 'w' : '-');
        $info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));
        
        // World
        $info .= (($perms & 0x0004) ? 'r' : '-');
        $info .= (($perms & 0x0002) ? 'w' : '-');
        $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));

        return $info;
    }

    public function file_storage_index_controller() {
        $listLink = collect(Route::getRoutes()->getRoutesByMethod()["GET"])->filter(fn($route) => ($route->getPrefix() === 'belajar-laravel/file-storage'));

        $data = [
            'title' => 'Daftar Isi Belajar File Storage Laravel',
            'links' => $listLink->reject(fn($route) => (Str::contains($route->uri(), '{')))->values()
        ];

        return view('belajar.index_2', $data);
    }

    /*
        Introduction

        Laravel provides a powerful filesystem abstraction thanks to the wonderful Flysystem PHP package by Frank de Jonge.
        The Laravel Flysystem integration provides simple drivers for working with local filesystems, SFTP, and Amazon S3.
        Even better, it's amazingly simple to switch between these storage options between your local development machine
        and production server as the API remains the same for each system.

        Configuration

        Laravel's filesystem configuration file is located at config/filesystems.php. Within this file, you may configure all
        of your filesystem "disks". Each disk represents a particular storage driver and storage location. Example configurations
        for each supported driver are included in the configuration file so you can modify the configuration to reflect your
        storage preferences and credentials.
        The local driver interacts with files stored locally on the server running the Laravel application while the s3 driver
        is used to write to Amazon's S3 cloud storage service.
        You may configure as many disks as you like and may even have multiple disks that use the same driver.
    */

    public function local_disk_controller() {
        /*
            The Local Driver

            When using the local driver, all file operations are relative to the root directory defined in your filesystems
            configuration file. By default, this value is set to the storage/app directory. Therefore, the following method
            would write to storage/app/example_local/teks.txt
        */
        $data = [
            'title' => 'Local Disk'
        ];

        if(Storage::disk('local')->exists('example_local/teks.txt')) {
            $contentTeks = [Storage::disk('local')->get('example_local/teks.txt'), self::berhasil];
        } else {
            $storeStatus = Storage::disk('local')->put('example_local/teks.txt', 'Selamat pagi, Semoga harimu menyenangkan');

            $statusUpload = self::boolean_to_string($storeStatus, 'Berhasil Menyimpan File', 'Gagal Menyimpan File');
        }

        $data['contentTeks'] = $contentTeks ?? ['File Tidak Ada', self::gagal];
        $data['statusUpload'] = $statusUpload ?? ['Tidak Ada Aktifitas Menyimpan File', self::gagal];


        return view('belajar.file_storage.local_disk', $data);
    }

    public function public_disk_controller() {
        $data = [
            'title' => 'Public Disk'
        ];

        /*
            The Public Disk

            The public disk included in your application's filesystems configuration file is intended for files that are going
            to be publicly accessible. By default, the public disk uses the local driver and stores its files in storage/app/public.
        */

        if(Storage::exists('example_public/kalimat.txt')) {
            $contentKalimat = [Storage::get('example_public/kalimat.txt'), self::berhasil];
        } else {
            $storeStatus = Storage::put('example_public/kalimat.txt', 'File Ini Bisa Diakses Oleh Web');

            $statusUpload = self::boolean_to_string($storeStatus, 'Berhasil Menyimpan File', 'Gagal Menyimpan File');
        }

        $data['contentKalimat'] = $contentKalimat ?? ['File Tidak Ada', self::gagal];
        $data['statusUpload'] = $statusUpload ?? ['Tidak Ada Aktivitas Menyimpan File', self::gagal];

        /*
            To make these files accessible from the web, you should create a symbolic link from public/storage to storage/app/public.
            Utilizing this folder convention will keep your publicly accessible files in one directory that can be easily shared
            across deployments when using zero down-time deployment systems like Envoyer.

            To create the symbolic link, you may use the storage:link Artisan command
            -> php artisan storage:link

            Once a file has been stored and the symbolic link has been created, you can create a URL to the files using the asset helper

            You may configure additional symbolic links in your filesystems configuration file. Each of the configured links will
            be created when you run the storage:link command
        */

        $data['linkToKalimat'] = asset('storage/example_public/kalimat.txt');
        $data['linkToDocument'] = asset('storage/document.pdf');
        $data['linkToImage'] = asset('storage/image-1.jpg');

        return view('belajar.file_storage.public_disk', $data);
    }

    public function general_storage_controller() {
        $data = [
            'title' => 'General File Storage'
        ];

        /*
            Obtaining Disk Instances

            The Storage facade may be used to interact with any of your configured disks. For example, you may use the put method on
            the facade to store a file on the default disk. If you call methods on the Storage facade without first calling the
            disk method, the method will automatically be passed to the default disk
        */

        if(Storage::exists('example_public/percakapan.txt')) {
            $percakapan = [Storage::get('example_public/percakapan.txt'), self::berhasil];
        } else {
            $storeStatus = Storage::put('example_public/percakapan.txt', 'Mari Melakukan Percakapan');

            $statusUploadPercakapan = self::boolean_to_string($storeStatus, 'Berhasil Menyimpan File', 'Gagal Menyimpan File');
        }

        $data['percakapan'] = $percakapan ?? ['File Tidak Ada', self::gagal];
        $data['statusUploadPercakapan'] = $statusUploadPercakapan ?? ['Tidak Ada Aktivitas Menyimpan File', self::gagal];

        /*
            If your application interacts with multiple disks, you may use the disk method on the Storage facade to work with files
            on a particular disk
        */

        if(Storage::disk('local')->exists('example_local/pengumuman.txt')) {
            $contentPengumuman = [Storage::disk('local')->get('example_local/pengumuman.txt'), self::berhasil];
        } else {
            $storeStatus = Storage::disk('local')->put('example_local/pengumuman.txt', 'Pengumuman !!! Saat ini kita sedang belajar Laravel');

            $statusUploadPengumuman = self::boolean_to_string($storeStatus, 'Berhasil Menyimpan File', 'Gagal Menyimpan File');
        }

        $data['contentPengumuman'] = $contentPengumuman ?? ['File Tidak Ada', self::gagal];
        $data['statusUploadPengumuman'] = $statusUploadPengumuman ?? ['Tidak Ada Aktivitas Menyimpan File', self::gagal];

        /*
            On-Demand Disks

            Sometimes you may wish to create a disk at runtime using a given configuration without that configuration actually being
            present in your application's filesystems configuration file. To accomplish this, you may pass a configuration array to
            the Storage facade's build method
        */
        $onDemandDisk = Storage::build([
            'driver' => 'local',
            'root' => storage_path('app/on_demand'),
            'throw' => false
        ]);

        if($onDemandDisk->exists('coba.txt')) {
            $contentCoba = [$onDemandDisk->get('coba.txt'), self::berhasil];
        } else {
            $storeStatus = $onDemandDisk->put('coba.txt', 'Ini Dibuat dengan On-Demand Disk');

            $statusUploadCoba = self::boolean_to_string($storeStatus, 'Berhasil Menyimpan File', 'Gagal Menyimpan File');
        }

        $data['contentCoba'] = $contentCoba ?? ['File Tidak Ada', self::gagal];
        $data['statusUploadCoba'] = $statusUploadCoba ?? ['Tidak Ada Aktivitas Menyimpan File', self::gagal];

        /*
            Retrieving Files

            The get method may be used to retrieve the contents of a file. The raw string contents of the file will be returned by
            the method. Remember, all file paths should be specified relative to the disk's "root" location. Contohnya sudah diberikan diatas

            If the file you are retrieving contains JSON, you may use the json method to retrieve the file and decode its contents
        */

        if(Storage::disk('local')->exists('example_local/data_json.txt')) {
            $contentJSON = [Storage::disk('local')->json('example_local/data_json.txt'), self::berhasil];
        } else {
            $arrData = [
                'nama' => 'Naruto Uzumaki',
                'hobi' => ['Olahraga', 'Makan Ramen', 'Ninja'],
                'umur' => 19
            ];

            $storeStatus = Storage::disk('local')->put('example_local/data_json.txt', Js::encode($arrData));

            $statusUploadJSON = self::boolean_to_string($storeStatus, 'Berhasil Menyimpan File', 'Gagal Menyimpan File');
        }

        $data['contentJSON'] = $contentJSON ?? [[], self::gagal];
        $data['statusUploadJSON'] = $statusUploadJSON ?? ['Tidak Ada Aktivitas Menyimpan File', self::gagal];

        // The exists method may be used to determine if a file exists on the disk
        $data['hasKalimat'] = self::boolean_to_string(Storage::exists('example_public/kalimat.txt'), 'true', 'false');
        $data['missingKalimat'] = self::boolean_to_string(Storage::missing('example_public/kalimat.txt'), 'true', 'false');

        // The missing method may be used to determine if a file is missing from the disk
        $data['missingRandom'] = self::boolean_to_string(Storage::missing('example_public/random.txt'), 'true', 'false');
        $data['hasRandom'] = self::boolean_to_string(Storage::exists('example_public/random.txt'), 'true', 'false');

        /*
            File URLs

            You may use the url method to get the URL for a given file. If you are using the local driver, this will typically just
            prepend /storage to the given path and return a relative URL to the file. If you are using the s3 driver, the fully
            qualified remote URL will be returned

            When using the local driver, all files that should be publicly accessible should be placed in the storage/app/public
            directory. Furthermore, you should create a symbolic link at public/storage which points to the storage/app/public directory.

            When using the local driver, the return value of url is not URL encoded. For this reason, we recommend always storing
            your files using names that will create valid URLs.
        */

        /*
            URL Host Customization

            If you would like to pre-define the host for URLs generated using the Storage facade, you may add a url option to the
            disk's configuration array
        */
        $data['UrlPublicKalimat'] = Storage::url('example_public/kalimat.txt'); // Ini jadi url karena konfigurasi public disk terdapat setting -> 'url' => env('APP_URL').'/storage'
        $data['UrlPublicKalimat2'] = asset('storage/example_public/kalimat.txt');
        $data['UrlLocalDocument'] = Storage::disk('local')->url('example_local/document-3.pdf'); // Ini jadi file path karena konfigurasi local disk tidak terdapat setting 'url'

        // $data['urlSementara'] = Storage::disk('local')->temporaryUrl('example_local/pengumuman.txt', now()->addMinutes(5)); (local dan public disk tidak support temporary url)

        /*
            File Metadata

            In addition to reading and writing files, Laravel can also provide information about the files themselves. For example, the size method may be used to get the size of a file in bytes
        */
        $data['sizePublicPercakapan'] = Storage::size('example_public/percakapan.txt');
        $data['sizeLocalDocument'] = Storage::disk('local')->size('example_local/document-3.pdf');

        /*
            The lastModified method returns the UNIX timestamp of the last time the file was modified
        */

        $data['lastPublicPercakapan'] = Carbon::createFromTimestamp(Storage::lastModified('example_public/percakapan.txt'))->toDayDateTimeString();
        $data['lastLocalDocument'] = Carbon::createFromTimestamp(Storage::disk('local')->lastModified('example_local/document-3.pdf'))->toDayDateTimeString();

        /*
            The MIME type of a given file may be obtained via the mimeType method
        */

        $data['mimePublicPercakapan'] = Storage::mimeType('example_public/percakapan.txt');
        $data['mimeLocalDocument'] = Storage::disk('local')->mimeType('example_local/document-3.pdf');

        /*
            File Paths

            You may use the path method to get the path for a given file. If you are using the local driver, this will return the
            absolute path to the file. If you are using the s3 driver, this method will return the relative path to the file in
            the S3 bucket
        */

        $data['pathPublicPercakapan'] = Storage::path('example_public/percakapan.txt');
        $data['pathLocalDocument'] = Storage::disk('local')->path('example_local/document-3.pdf');

        /*
            Storing Files

            The put method may be used to store file contents on a disk. You may also pass a PHP resource to the put method, which
            will use Flysystem's underlying stream support. Remember, all file paths should be specified relative to the "root"
            location configured for the disk

            If the put method (or other "write" operations) is unable to write the file to disk, false will be returned

            If you wish, you may define the throw option within your filesystem disk's configuration array. When this option is
            defined as true, "write" methods such as put will throw an instance of League\Flysystem\UnableToWriteFile when write
            operations fail
        */

        if(Storage::missing('example_public/image-1.jpg')) {
            $file = fopen(Storage::disk('local')->path('dump_file/image-1.jpg'), 'r+');

            // Bisa juga ditulis
            // $file = fopen(storage_path('app/dump_file/image-1.jpg'), 'r+');

            Storage::put('example_public/image-1.jpg', $file) ?: throw new \ErrorException("Gagal Menyimpan File");

            fclose($file);
        }

        $data['urlImage1'] = Storage::url('example_public/image-1.jpg');

        // Bisa juga ditulis
        // $data['urlImage1'] = asset('storage/example_public/image-1.jpg');

        /*
            Prepending & Appending To Files

            The prepend and append methods allow you to write to the beginning or end of a file
        */

        if(Storage::exists('example_public/kalimat.txt')) {
            $teks = Storage::get('example_public/kalimat.txt');
            $teksAwal = 'Teks ini ditambahkan di awal';
            $teksAkhir = 'Teks ini ditambahkan di akhir';

            if(!Str::startsWith($teks, $teksAwal)) {
                Storage::prepend('example_public/kalimat.txt', $teksAwal . ' ') ?: throw new \ErrorException("Gagal Melakukan Operasi Prepend");
            }

            if(!Str::endsWith($teks, $teksAkhir)) {
                Storage::append('example_public/kalimat.txt', ' ' . $teksAkhir) ?: throw new \ErrorException("Gagal Melakukan Operasi Append");
            }
        }

        $data['PublicKalimat'] = Storage::get('example_public/kalimat.txt');

        /*
            Copying & Moving Files

            The copy method may be used to copy an existing file to a new location on the disk, while the move method may be used to rename
            or move an existing file to a new location
        */

        if(Storage::missing('example_public/image-2.jpg')) {
            // Copy
            Storage::disk('local')->copy('dump_file/image-2.jpg', 'public/example_public/image-2.jpg') ?: throw new \ErrorException("Gagal Mengcopy File");
        }

        if(Storage::missing('example_public/image-3.jpg')) {
            // Move
            Storage::disk('local')->move('dump_file/image-3.jpg', 'public/example_public/image-3.jpg') ?: throw new \ErrorException("Gagal Memindahkan File");
        }

        if(Storage::exists('example_public/screenshot.png')) {
            // Rename
            Storage::move('example_public/screenshot.png', 'example_public/gambar.png') ?: throw new \ErrorException("Gagal Me-rename File");
        }

        /*
            Automatic Streaming

            Streaming files to storage offers significantly reduced memory usage. If you would like Laravel to automatically manage
            streaming a given file to your storage location, you may use the putFile or putFileAs method. This method accepts
            either an Illuminate\Http\File or Illuminate\Http\UploadedFile instance and will automatically stream the file to
            your desired location

            There are a few important things to note about the putFile method. Note that we only specified a directory name and not
            a filename. By default, the putFile method will generate a unique ID to serve as the filename. The file's extension will
            be determined by examining the file's MIME type. The path to the file will be returned by the putFile method so you can
            store the path, including the generated filename, in your database.

            The putFile and putFileAs methods also accept an argument to specify the "visibility" of the stored file. This is particularly
            useful if you are storing the file on a cloud disk such as Amazon S3 and would like the file to be publicly accessible via
            generated URLs
        */
        // Automatically generate a unique ID for filename...
        // Hanya mendefinisikan lokasi foldernya saja, VVV , karena nama file otomatis di generate
        // $data['video1Path'] = Storage::putFile('example_public', new File(storage_path('app/dump_file/video-1.mkv')));
        // $data['mimeVideo1'] = Storage::mimeType($data['video1Path']);
        // $data['linkVideo1'] = asset('storage/' . $data['video1Path']);

        // Manually specify a filename...
        // Sama seperti method putFile() kita hanya mendefinisikan lokasi foldernya saja pada argumen pertama
        // Akan tetapi, ada tambahan argumen ketiga untuk mendefinisikan nama filenya
        if (Storage::missing('example_public/anime-bochi.mp4')) {
            $data['video2Path'] = Storage::putFileAs('example_public', new File(storage_path('app/dump_file/video-2.mp4')), 'anime-bochi.mp4');
        } else {
            $data['video2Path'] = 'example_public/anime-bochi.mp4';
        }

        $data['mimeVideo2'] = Storage::mimeType($data['video2Path']);
        $data['linkVideo2'] = route('file.video-response-for-chrome', ['filename' => 'anime-bochi.mp4']);

        return view('belajar.file_storage.general_storage', $data);
    }

    public function download_file_controller() {
        if(Storage::disk('local')->missing('example_local/document-3.pdf')) {
            (Storage::disk('local')->copy('dump_file/document-3.pdf', 'example_local/document-3.pdf')) ?: throw new \ErrorException('Gagal Meng-copy file');
        }

        /*
            Downloading Files

            The download method may be used to generate a response that forces the user's browser to download the file at the
            given path. The download method accepts a filename as the second argument to the method, which will determine
            the filename that is seen by the user downloading the file. Finally, you may pass an array of HTTP headers as
            the third argument to the method
        */

        return Storage::disk('local')->download('example_local/document-3.pdf', 'file_jurnal-3.pdf');
    }

    public function video_response_for_chrome_controller(string $filename) {
        // Permasalahan yang terjadi yaitu, video tidak bisa lompat ke timestamp yang diinginkan
        // Penjelasan Masalah Lebih Detail: https://stackoverflow.com/questions/8088364/html5-video-will-not-loop
        return response()->file(Storage::path('example_public/' . $filename));
    }

    public function form_file_display_controller() {
        $data = [
            'title' => 'Form Upload File'
        ];

        return view('belajar.file_storage.form_file', $data);
    }

    public function form_file_process_controller(Request $request) {
        /*
            File Uploads

            In web applications, one of the most common use-cases for storing files is storing user uploaded files such as photos and
            documents. Laravel makes it very easy to store uploaded files using the store method on an uploaded file instance. Call
            the store method with the path at which you wish to store the uploaded file

            There are a few important things to note about this example. Note that we only specified a directory name, not a filename.
            By default, the store method will generate a unique ID to serve as the filename. The file's extension will be determined
            by examining the file's MIME type. The path to the file will be returned by the store method so you can store the
            path, including the generated filename, in your database.

            You may also call the putFile method on the Storage facade to perform the same file storage operation as the example above
        */

        $redirectForm = redirect()->route('file.form');
        $success = [];
        $fail = [];
        $info = [];

        if($request->hasFile('file_upload1')) {
            $pathUploadedFile1 = $request->file('file_upload1')->store('uploaded'); // store() method mirip dengan Storage::putFile()
            // Bisa ditulis
            // $pathUploadedFile1 = Storage::putFile('uploaded', $request->file('file_upload1'));

            if ($pathUploadedFile1) {
                $success[] = $pathUploadedFile1;
            } else {
                $fail[] = 'Failed To Store File 1';
            }
        } else {
            $fail[] = 'Uploaded File 1 Is Not Valid';
        }

        /*
            Specifying A File Name

            If you do not want a filename to be automatically assigned to your stored file, you may use the storeAs method, which
            receives the path, the filename, and the (optional) disk as its arguments

            You may also use the putFileAs method on the Storage facade, which will perform the same file storage operation as
            the example above

            Unprintable and invalid unicode characters will automatically be removed from file paths. Therefore, you may wish
            to sanitize your file paths before passing them to Laravel's file storage methods. File paths are normalized using
            the League\Flysystem\WhitespacePathNormalizer::normalizePath method.
        */

        if ($request->hasFile('file_upload2') && $request->filled('file_name2')) {
            $pathUploadedFile2 = $request->file('file_upload2')->storeAs('uploaded', $request->input('file_name2'));
            // Bisa juga ditulis
            // $pathUploadedFile2 = Storage::putFileAs('uploaded', $request->file('file_upload2'), $request->input('file_name2'));

            if ($pathUploadedFile2) {
                $success[] = $pathUploadedFile2;
            } else {
                $fail[] = 'Failed To Store File 2';
            }
        } else {
            $fail[] = 'Uploaded File 2 Is Not Valid or Filename Field is Empty';
        }

        /*
            Specifying A Disk

            By default, this uploaded file's store method will use your default disk. If you would like to specify another disk, pass
            the disk name as the second argument to the store method

            If you are using the storeAs method, you may pass the disk name as the third argument to the method
        */

        if ($request->hasFile('file_upload3')) {
            $folder = ($request->input('disk_3') === 'local') ? '_local' : '';

            // You can set the visibility when writing the file via the put(), putFile() and putFileAs() method
            if ($request->filled('file_name3')) {
                // $pathUploadedFile3 = $request->file('file_upload3')->storeAs('uploaded' . $folder, $request->input('file_name3'), $request->input('disk_3'));
                $pathUploadedFile3 = Storage::disk($request->input('disk_3'))->putFileAs('uploaded' . $folder, $request->file('file_upload3'), $request->input('file_name3'), $request->input('visibility_3'));
            } else {
                // $pathUploadedFile3 = $request->file('file_upload3')->store('uploaded' . $folder, $request->input('disk_3'));
                $pathUploadedFile3 = Storage::disk($request->input('disk_3'))->putFile('uploaded' . $folder, $request->file('file_upload3'), $request->input('visibility_3'));
            }

            if ($pathUploadedFile3) {
                $success[] = $pathUploadedFile3;
            } else {
                $fail[] = 'Failed To Store File 3';
            }

            /*
                Other Uploaded File Information

                If you would like to get the original name and extension of the uploaded file, you may do so using the getClientOriginalName
                and getClientOriginalExtension methods

                However, keep in mind that the getClientOriginalName and getClientOriginalExtension methods are considered unsafe, as the
                file name and extension may be tampered with by a malicious user. For this reason, you should typically prefer the
                hashName and extension methods to get a name and an extension for the given file upload
            */

            $info['file_upload3Info'] = [
                'Client_Original_Name' => $request->file('file_upload3')->getClientOriginalName(),
                'Client_Original_Extension' => $request->file('file_upload3')->getClientOriginalExtension(),
                'Client_Guess_Extension' => $request->file('file_upload3')->guessClientExtension(),
                'Client_Extension' => $request->file('file_upload3')->clientExtension(),
                'Client_MIME_Type' => $request->file('file_upload3')->getClientMimeType(),
                'Hash_Name' => $request->file('file_upload3')->hashName(), // Generate a unique, random name and use the right extension
                'Trusted_Extension' => $request->file('file_upload3')->extension(), // Determine the file's extension based on the file's MIME type...
                'Trusted_Guess_Extension' => $request->file('file_upload3')->guessExtension(),
                'Trusted_MIME_Type' => $request->file('file_upload3')->getMimeType(),
                'Path' => $request->file('file_upload3')->path(),
                'Get_Path' => $request->file('file_upload3')->getPath(),
                'Get_Path_Name' => $request->file('file_upload3')->getPathname(),
                'Get_Real_Path' => $request->file('file_upload3')->getRealPath(),
                'Get_Base_Name' => $request->file('file_upload3')->getBasename(),
                'Get_Filename' => $request->file('file_upload3')->getFilename(),
                'Get_Permission' => $request->file('file_upload3')->getPerms(),
                'Get_Permission_Formatted' => decoct($request->file('file_upload3')->getPerms() & 0777), 
                'Get_Permission_Formatted_2' => substr(sprintf('%o', $request->file('file_upload3')->getPerms()), -4),
                'Get_Permission_Formatted_3' => self::formatted_file_permission($request->file('file_upload3')->getPerms())
            ];

            $request->session()->flash('file_info3', $info['file_upload3Info']);
        } else {
            $fail[] = 'Uploaded File 2 Is Not Valid';
        }

        if(count($success) !== 0) {
            $redirectForm->with('success', implode(', ', $success));
        }

        if(count($fail) !== 0) {
            $redirectForm->with('fail', implode(', ', $fail));
        }

        $request->session()->flash('tes', 'Ini Flash Tes');

        return $redirectForm;
    }

    public function uploaded_file_display() {
        $data = [
            'title' => 'List All Uploaded File'
        ];

        /*
            Get All Files Within A Directory

            The files method returns an array of all of the files in a given directory. If you would like to retrieve a list of all files
            within a given directory including all subdirectories, you may use the allFiles method
        */

        $data['files'] = [];
        $data['filesInUploadedFolder'] = Str::afterLast(Storage::path('uploaded'), 'belajar-2/');
        $files = Storage::files('uploaded');

        // $data['allFileRecursive'] = Storage::disk('local')->allFiles('/');
        // Bisa juga ditulis
        // $data['allFileRecursive'] = Storage::disk('local')->files('/', true);

        foreach ($files as $path) {
            $urlPath = Storage::url($path);
            $filename = Str::afterLast($urlPath, '/');

            $data['files'][] = ['url' => $urlPath, 'name' => $filename, 'delete' => route('file.uploaded_delete', ['filename' => $filename])];
        }

        /*
            Get All Directories Within A Directory

            The directories method returns an array of all the directories within a given directory. Additionally, you may use the
            allDirectories method to get a list of all directories within a given directory and all of its subdirectories
        */

        $data['directories'] = [];
        $data['rootFolderLocal'] = Str::afterLast(Storage::disk('local')->path('/'), 'belajar-2/');
        $directories = Storage::disk('local')->directories('/', true);

        // $data['allDirectoryRecursive'] = Storage::disk('local')->allDirectories('/');
        // Bisa juga ditulis
        // $data['allDirectoryRecursive'] = Storage::disk('local')->directories('/', true);

        foreach ($directories as $directory) {
            $data['directories'][] = $directory;
        }

        // Cek apakah folder tidak ada
        if (Storage::disk('local')->directoryMissing('tes_make_delete')) {
            // The makeDirectory method will create the given directory, including any needed subdirectories
            $data['statusFolderTes'] = Storage::disk('local')->makeDirectory('tes_make_delete') ? 'Berhasil Membuat Folder tes_make_delete' : 'Gagal Membuat Folder tes_make_delete';
        } else {
            // Finally, the deleteDirectory method may be used to remove a directory and all of its files
            $data['statusFolderTes'] = Storage::disk('local')->deleteDirectory('tes_make_delete') ? 'Berhasil Menghapus Folder tes_make_delete' : 'Gagal Menghapus Folder tes_make_delete';
        }

        /*
            File Visibility

            In Laravel's Flysystem integration, "visibility" is an abstraction of file permissions across multiple platforms. Files may
            either be declared public or private. When a file is declared public, you are indicating that the file should generally
            be accessible to others. For example, when using the S3 driver, you may retrieve URLs for public files.

            You can set the visibility when writing the file via the put method
            Storage::put('file.jpg', $contents, 'public');

            If the file has already been stored, its visibility can be retrieved and set via the getVisibility and setVisibility methods

            When interacting with uploaded files, you may use the storePublicly and storePubliclyAs methods to store the uploaded file
            with public visibility

            Local Files & Visibility

            When using the local driver, public visibility translates to 0755 permissions for directories and 0644 permissions for files.
            You can modify the permissions mappings in your application's filesystems configuration file

            Storage::getVisibility() hanya bisa dipakai untuk mengecek file visibility, untuk folder tidak bisa
        */

        for ($i = 0; $i < count($files); $i++) {
            $visibility = Storage::getVisibility($files[$i]);

            $data['files'][$i]['visibility'] = $visibility;
        }

        Storage::disk('dropbox');

        return view('belajar.file_storage.show_uploaded_file', $data);
    }

    public function delete_uploaded_file(string $filename) {
        // The delete method accepts a single filename or an array of files to delete
        // If necessary, you may specify the disk that the file should be deleted from
        if (Storage::delete('uploaded/' . $filename)) {
            return redirect()->route('file.uploaded_display')->with('success', "File $filename berhasil dihapus");
        } else {
            return redirect()->route('file.uploaded_display')->with('error', "File $filename gagal dihapus");
        }
    }

    public function form_upload_dropbox_controller() {
        $data = [
            'title' => 'Form Upload Ke Dropbox'
        ];

        return view('belajar.file_storage.dropbox_form', $data);
    }

    public function form_process_dropbox_controller (Request $request) {
        $redirectForm = redirect()->route('file.dropbox_form');

        /*
            Retrieving Uploaded Files

            You may retrieve uploaded files from an Illuminate\Http\Request instance using the file method or using dynamic properties.
            The file method returns an instance of the Illuminate\Http\UploadedFile class, which extends the PHP SplFileInfo class and
            provides a variety of methods for interacting with the file

            You may determine if a file is present on the request using the hasFile method

            In addition to checking if the file is present, you may verify that there were no problems uploading the file via the isValid method
        */

        if ($request->hasFile('file_upload') && $request->file('file_upload')->isValid()) {
            /*
                The UploadedFile class also contains methods for accessing the file's fully-qualified path and its extension. The extension
                method will attempt to guess the file's extension based on its contents. This extension may be different from the extension
                that was supplied by the client

                There are a variety of other methods available on UploadedFile instances. Check out the API documentation for the class for
                more information regarding these methods.

                Mayoritas sudah dicoba diatas
            */
            $info = [
                'Trusted_Extension' => $request->file('file_upload')->extension(),
                'Upload_Temporary_Path' => $request->file('file_upload')->path()
            ];

            $redirectForm->with('info', $info);

            /*
                Storing Uploaded Files

                To store an uploaded file, you will typically use one of your configured filesystems. The UploadedFile class has a store
                method that will move an uploaded file to one of your disks, which may be a location on your local filesystem or a cloud
                storage location like Amazon S3

                The store method accepts the path where the file should be stored relative to the filesystem's configured root directory.
                This path should not contain a filename, since a unique ID will automatically be generated to serve as the filename.

                The store method also accepts an optional second argument for the name of the disk that should be used to store the file.
                The method will return the path of the file relative to the disk's root

                If you do not want a filename to be automatically generated, you may use the storeAs method, which accepts the
                path, filename, and disk name as its arguments

                For more information about file storage in Laravel, check out the complete file storage documentation.
            */

            if ($request->filled('file_name')) {
                $dataFile = explode('.', $request->input('file_name'));

                if (count($dataFile) < 2) {
                    $filename = $dataFile[0] . '.' . $request->file('file_upload')->extension();
                } else {
                    $ekstensi = strtolower(last($dataFile));

                    if ($ekstensi !== $request->file('file_upload')->extension()) {
                        array_pop($dataFile);

                        $filename = implode('.', $dataFile) . '.' . $request->file('file_upload')->extension();
                    } else {
                        $filename = implode('.', $dataFile);
                    }
                }

                $uploadedPath = $request->file('file_upload')->storeAs('/uploaded_laravel', $filename, 'dropbox');
            } else {
                $uploadedPath = $request->file('file_upload')->store('/uploaded_laravel', 'dropbox');
            }

            if ($uploadedPath) {
                $redirectForm->with('success', $uploadedPath);
            } else {
                $redirectForm->with('fail', 'Fail Upload To Dropbox');
            }
        } else {
            $redirectForm->with('fail', 'No Uploaded File or Uploaded File Is Not Valid');
        }

        return $redirectForm;
    }

    public function dropbox_file_controller() {
        $data = [
            'title' => 'Dropbox File'
        ];

        $allFiles = Storage::disk('dropbox')->files('uploaded_laravel');
        
        $data['files'] = [];
        foreach ($allFiles as $file) {
            $path = Storage::disk('dropbox')->path($file);
            $filename = Str::afterLast($path, '/');
            $mimeType = Storage::disk('dropbox')->mimeType($file);

            $data['files'][] = [
                'path' => $path,
                'filename' => $filename,
                'lastModified' => Carbon::createFromTimestamp(Storage::disk('dropbox')->lastModified($file))->toDayDateTimeString(),
                'size' => Storage::disk('dropbox')->size($file),
                'mimeType' => $mimeType,
                'downloadUrl' => Storage::disk('dropbox')->url($file),
                'sourceUrl' => route('file.dropbox_file', ['mime' => str_replace('/', '_', $mimeType), 'filename' => $filename])
            ];
        }

        return view('belajar.file_storage.dropbox_display', $data);
    }

    public function dropbox_file_uploaded_response_controller(string $mime, string $filename) {
        if (Str::is(['audio_*', 'video_*'], $mime)) {
            return Storage::disk('dropbox')->response('uploaded_laravel/' . $filename, headers: ['Accept-Ranges' => 'bytes']);
        } else {
            return Storage::disk('dropbox')->response('uploaded_laravel/' . $filename);
        }
    }

    public function delete_dropbox_uploaded_file_controller(Request $request) {
        if ($request->filled('filename')) {
            $redirectTo = redirect()->route('file.display_dropbox_file');

            if (Storage::disk('dropbox')->delete('uploaded_laravel/' . $request->input('filename'))) {
                $redirectTo->with('success', 'File ' . $request->input('filename') . ' has been deleted');
            } else {
                $redirectTo->with('fail', 'Failed to delete ' . $request->input('filename'));
            }

            return $redirectTo;
        } else {
            return response(status: 404);
        }
    }
}
