<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coba Blade Templating Engine</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
    <link rel="shortcut icon" type="image/png" href="favicon.png">
</head>
<body>
    <h1>Belajar Blade Templating Engine</h1>

    <ul>
        <li><a href="/" title="Home">Home</a></li>
    </ul>

    <p>
        Blade is the simple, yet powerful templating engine that is included with Laravel. Unlike some PHP templating engines,
        Blade does not restrict you from using plain PHP code in your templates. In fact, all Blade templates are compiled into
        plain PHP code and cached until they are modified, meaning Blade adds essentially zero overhead to your application.
        Blade template files use the .blade.php file extension and are typically stored in the resources/views directory.
    </p>
    <p>
        Blade views may be returned from routes or controllers using the global view helper. Of course, as mentioned in the
        documentation on views, data may be passed to the Blade view using the view helper's second argument
    </p>
    <p>
        Want to take your Blade templates to the next level and build dynamic interfaces with ease? Check out Laravel Livewire.
        Livewire allows you to write Blade components that are augmented with dynamic functionality that would typically only be
        possible via frontend frameworks like React or Vue, providing a great approach to building modern, reactive frontends
        without the complexities, client-side rendering, or build steps of many JavaScript frameworks.
    </p>

    <h2>1. Displaying Data</h2>
    <div class="php">
        {{--
            You may display data that is passed to your Blade views by wrapping the variable in curly braces.

            Blade's {{ }} echo statements are automatically sent through PHP's htmlspecialchars function to prevent XSS attacks.

            You are not limited to displaying the contents of the variables passed to the view. You may also echo the results of any
            PHP function. In fact, you can put any PHP code you wish inside of a Blade echo statement
            --}}

        {{ $nama }}
        <br>
        {{ $ada_html1 }}
        <br>
        The current UNIX timestamp is {{ time() }}
    </div>

    <h2>2. Displaying Unescaped Data</h2>
    <div class="php">
        {{--
            By default, Blade {{ }} statements are automatically sent through PHP's htmlspecialchars function to prevent XSS
            attacks. If you do not want your data to be escaped, you may use the following syntax
            --}}
        
        {!! $ada_html2 !!}

        {{--
            Be very careful when echoing content that is supplied by users of your application. You should typically use the
            escaped, double curly brace syntax to prevent XSS attacks when displaying user supplied data.
            --}}
    </div>

    <h2>3. Nonaktifkan otomatis e() function (double encode HTML entities) milik Laravel</h2>
    <div class="php">
        By default, Blade (and the Laravel e helper) will double encode HTML entities. If you would like to disable double
        encoding, call the Blade::withoutDoubleEncoding method from the boot method of your AppServiceProvider
    </div>

    <h2>4. Blade & JavaScript Frameworks & Ignoring Blade Format</h2>
    <div class="php">
        {{--
            Since many JavaScript frameworks also use "curly" braces to indicate a given expression should be displayed in the
            browser, you may use the @ symbol to inform the Blade rendering engine an expression should remain untouched.
            --}}

        @{{ $hello }}
        <br>
        {{--
            In this example, the @ symbol will be removed by Blade; however, {{ name }} expression will remain untouched by the
            Blade engine, allowing it to be rendered by your JavaScript framework.
            --}}

        {{-- The @ symbol may also be used to escape Blade directives --}}
        @@if ($nama === "Randi1")
            Ada Randi
        @@endif
    </div>

    <h2>5. Rendering JSON</h2>
    <div class="php">
        {{-- Sometimes you may pass an array to your view with the intention of rendering it as JSON in order to initialize a JavaScript variable. --}}
        @foreach ($data_json as $key => $value)
            {{ $key }} => {{ $value }}<br>
        @endforeach

        <br>
        Manual json_encode() = {!! json_encode($data_json) !!}
        <br><br>

        <script>
            let data_json = {!! "'" . json_encode($data_json) . "'" !!};
            let obj = {!! json_encode($data_json) !!};

            console.log(data_json);
            console.log(obj);
            console.log('----------------------------------------------------------------------------------------------------');
            // Mengubah JSON jadi Object
            console.log(JSON.parse(data_json));
            // Mengubah Object jadi JSON
            console.log(JSON.stringify(obj));
            console.log('----------------------------------------------------------------------------------------------------');
        </script>

        {{--
            However, instead of manually calling json_encode, you may use the Illuminate\Support\Js::from method directive. The from
            method accepts the same arguments as PHP's json_encode function; however, it will ensure that the resulting JSON is
            properly escaped for inclusion within HTML quotes. The from method will return a string JSON.parse JavaScript statement
            that will convert the given object or array into a valid JavaScript object
            --}}
        
        Using \Illuminate\Support\Js::from() = {!! \Illuminate\Support\Js::from($data_json) !!}
        <br><br>

        <script>
            let data_from = {{ \Illuminate\Support\Js::from($data_json) }};

            console.log(data_from);
            console.log('----------------------------------------------------------------------------------------------------');
        </script>

        {{--
            The latest versions of the Laravel application skeleton include a Js facade, which provides convenient access to this
            functionality within your Blade templates
            --}}

        Using Js::from() = {!! Js::from($data_json) !!}
        
        <script>
            let data_from2 = {{ Js::from($data_json) }};

            console.log(data_from2);
        </script>

        {{--
            You should only use the Js::from method to render existing variables as JSON. The Blade templating is based on regular
            expressions and attempts to pass a complex expression to the directive may cause unexpected failures.
            --}}
    </div>

    <h2>6. The @@verbatim Directive</h2>
    <div class="php">
        {{--
            If you are displaying JavaScript variables in a large portion of your template, you may wrap the HTML in the @@verbatim
            directive so that you do not have to prefix each Blade echo statement with an @ symbol
            --}}

        @verbatim
            Disini blade template engine tidak berlaku {{ $nama }}
            <br>

            @if ($nama === 'Randi')
                Yo!
            @endif
        @endverbatim
    </div>

    <p>
        In addition to template inheritance and displaying data, Blade also provides convenient shortcuts for common PHP control
        structures, such as conditional statements and loops. These shortcuts provide a very clean, terse way of working with
        PHP control structures while also remaining familiar to their PHP counterparts.
    </p>

    <h2>1. If Statements</h2>
    <div class="php">
        @verbatim
            You may construct if statements using the @if, @elseif, @else, and @endif directives. These directives function
            identically to their PHP counterparts
        @endverbatim

        <br>

        @foreach ($data as $value)
            @if (is_string($value))
                Ini adalah string, isinya {{ $value }}<br>
            @elseif (($value % 2) === 0)
                Ini adalah angka genap {{ $value }}<br>
            @else
                Ini adalah angka ganjil {{ $value }}<br>
            @endif
        @endforeach
    </div>

    <h3>1.2 @@unless Statement</h3>
    <div class="php">
        @verbatim
            For convenience, Blade also provides an @@unless directive
        @endverbatim

        <br>

        {{--
            Jika kondisi benar maka isi unless tidak ditampilkan
            Jika kondisi salah maka isi unless akan ditampilkan
            --}}
        @unless ($nama === "Randi")
            Ini di dalam @@unless
            <br>
            Isi $nama = {{ $nama }}
        @endunless
    </div>

    <h3>1.3 @@isset Statement</h3>
    <div class="php">
        {{--
            Jika variabel ada dan isinya tidak null, maka isi isset ditampilkan
            Jika variabel tidak ada atau isinya null, maka isi isset tidak ditampilkan

            Sifatnya sama seperti function isset()
            --}}
        @isset($nama)
            Variabel $nama benar telah di-set
            <br>
            Isinya {{ $nama }}
        @endisset
    </div>

    <h3>1.4 @@empty</h3>
    <div class="php">
        {{--
            Jika variabel ada dan ada isinya, maka isi empty tidak ditampilkan
            Jika variabel tidak ada atau tidak ada isinya, maka isi empty akan ditampilkan

            Sifatnya sama seperti function empty()
            --}}
        @empty($kosong)
            Variabel $kosong isinya kosong
        @endempty
    </div>

    <h3>1.5 Environment Directives</h3>
    <div class="php">
        {{--
            You may check if the application is running in the production environment using the production directive

            Setting ini dapat diubah pada file .env bagian APP_ENV yang akan dibaca oleh file config/app.php nanti
            --}}

        Saat ini sedang berada di enviroment {{ config('app.env') }}

        <br>
        
        @production
            Ini Akan Muncul Jika kita berada pada production enviroment
            <br>
        @endproduction

        {{--
            Or, you may determine if the application is running in a specific environment using the env directive
            --}}
        @env(['local', 'staging'])
            Ini akan muncul pada local enviroment atau staging enviroment
        @endenv
    </div>

    <h2>2. Switch Statements</h2>
    <div class="php">
        @verbatim
            Switch statements can be constructed using the @switch, @case, @break, @default and @endswitch directives
        @endverbatim

        <br>

        @foreach ($data as $value)
            @switch((is_string($value)) ? $value : ($value % 2))
                @case('Randi')
                Ini adalah string, isinya {{ $value }}<br>
                    @break
                @case(0)
                Bilangan Ini Genap {{ $value }}<br>
                    @break
                @default
                    Bilangan Ini Ganjil {{ $value }}<br>
            @endswitch
        @endforeach
    </div>

    <h2>3. Loop Statement</h2>
    
    <p>
        In addition to conditional statements, Blade provides simple directives for working with PHP's loop structures. Again,
        each of these directives functions identically to their PHP counterparts
    </p>

    <h3>3.1 @@for loop</h3>
    <div class="php">
        @for ($i = 1; $i <= 10; $i++)
            Ini perulangan ke-{{ $i }}<br>
        @endfor
    </div>

    <h3>3.2 @@while loop</h3>
    <div class="php">
        @while ($i > 0)
            Ini perulangan ke-{{ $i }}<br>
            <?php $i--; ?>
        @endwhile
    </div>

    <h3>3.3 @@forelse loop</h3>
    <div class="php">
        @verbatim
            <p>
                Briefly @foreach in blade Laravel statement is used when you are trying to loop over an array of things, Say you have
                data for users stored in a variable called $users and you need to go over them
            </p>
            <p>
                But let's say you have no data ?! the array you are looping through is empty what do you do then?
            </p>
            <p>
                When there is no data to present the table just went empty. So @forelse solves this by having an empty statement scope
                that allows you to write something when there is no data.
            </p>
        @endverbatim

        Jika ada isinya:
        <ul>
        @forelse ($data as $value)
            <li>{{ $value }}</li>
        @empty
            <li>Data Kosong :O</li>
        @endforelse
        </ul>

        Jika Array Kosong:
        <ul>
        @forelse ($arr_kosong as $value)
            <li>{{ $value }}</li>
        @empty
            <li>Data Kosong</li>
        @endforelse
        </ul>
        
    </div>

    <h3>3.4 @@continue dan @@break</h3>
    <div class="php">
        @verbatim
            <p>
                When using loops you may also skip the current iteration or end the loop using the @continue and @break directives
            </p>
        @endverbatim

        Continue:
        <br>
        @foreach ($data as $value)
            @if ($value === 2)
                Ini di-skip<br>
                @continue
            @endif

            Nilai $value = {{ $value }}<br>
        @endforeach
        
        <br>
        Break:
        <br>
        @foreach ($data as $value)
            @if ($value === 'Randi')
                Ini Break<br>
                @break
            @endif

            Nilai $value = {{ $value }}<br>
        @endforeach

        @verbatim
            <p>
                You may also include the continuation or break condition within the directive declaration
            </p>
        @endverbatim

        Continue():
        <br>
        @foreach ($data as $value)
            @continue($value === 'Randi')

            Nilai $value = {{ $value }}<br>
        @endforeach

        <br>
        Break():
        <br>
        @foreach ($data as $value)
            @break($value === 4)

            Nilai $value = {{ $value }}<br>
        @endforeach

    </div>

    <h3>3.5 @@foreach loop</h3>
    <div class="php">
        @foreach ($data as $value)
            Nilai $value = {{ $value }}<br>
        @endforeach

        <p>
            While iterating through a foreach loop, you may use the loop variable to gain valuable information about the loop, such
            as whether you are in the first or last iteration through the loop.
        </p>
    </div>

    <h4>3.5.1 The Loop Variable</h4>
    <div class="php">
        <p>
            While iterating through a foreach/forelse loop, a $loop variable will be available inside of your loop. This variable provides
            access to some useful bits of information such as the current loop index and whether this is the first or last iteration
            through the loop
        </p>
        <p>
            If you are in a nested loop, you may access the parent loop's $loop variable via the parent property
        </p>
        <p>
            The $loop variable also contains a variety of other useful properties
        </p>
        <ul>
            <li><b>index</b> = The index of the current loop iteration (starts at 0).</li>
            <li><b>iteration</b> = The current loop iteration (starts at 1).</li>
            <li><b>remaining</b> = The iterations remaining in the loop.</li>
            <li><b>count</b> = The total number of items in the array being iterated.</li>
            <li><b>first</b> = Whether this is the first iteration through the loop.</li>
            <li><b>last</b> = Whether this is the last iteration through the loop.</li>
            <li><b>even</b> = Whether this is an even iteration through the loop.</li>
            <li><b>odd</b> = Whether this is an odd iteration through the loop.</li>
            <li><b>depth</b> = The nesting level of the current loop.</li>
            <li><b>parent</b> = When in a nested loop, the parent's loop variable.</li>
        </ul>

        @foreach ($data as $value)
            Value = {{ $value }}<br>
            index = {{ $loop->index }}<br>
            iteration = {{ $loop->iteration }}<br>
            remaining = {{ $loop->remaining }}<br>
            count = {{ $loop->count }}<br>
            first = {{ $loop->first }}<br>
            last = {{ $loop->last }}<br>
            even = {{ $loop->even }}<br>
            odd = {{ $loop->odd }}<br>
            depth = {{ $loop->depth }}<br>
            parent = <?php var_dump($loop->parent); ?><br><br>
        @endforeach

        <br>
        Array Bersarang:
        <br>
        @forelse ($arr_bersarang as $value1)
            @forelse ($value1 as $value)
                Value = {{ $value }}
                @php
                    var_dump($loop);
                @endphp
                @empty
                    Kosong XD 2<br>
            @endforelse
            @empty
                Kosong XD 1<br>
        @endforelse
    </div>

    <h2>4. Conditional Classes & Styles</h2>
    <div class="php">
        <p>
            The @@class directive conditionally compiles a CSS class string. The directive accepts an array of classes where the
            array key contains the class or classes you wish to add, while the value is a boolean expression. If the array element
            has a numeric key, it will always be included in the rendered class list
        </p>
        <p @class([
            'p-4', // Muncul class="p-4"
            'font-bold' => true, // Muncul class="font-bold" karena true
            'pt-5' => false, // Tidak muncul class="pt-5" karena false
            1 => true, // Muncul class="1" karena value-nya true
            2 => 'Nasi', // Muncul class="Nasi", walaupun itu merupakan value-nya (Seharusnya key yang menjadi isi dari property class nanti, bukan value-nya) (?) (Tidak disarankan)
            3 => false, // Tidak muncul class="3" karena value-nya false
            4, 7 // Muncul class="4 7"
        ])>
            Tag paragraf ini punya attribute class yang isinya ditentukan oleh @@class milik blade template
        </p>

        <p>
            Likewise, the @@style directive may be used to conditionally add inline CSS styles to an HTML element
        </p>
        <p @style([
            'text-align: center',
            'font-weight: bold' => false,
            'border: 1px solid green' => true
        ])>
            Tag paragraf ini punya inline style CSS yang isinya ditentukan oleh @@style milik blade template
        </p>
    </div>

    <h2>5. Additional Attributes</h2>
    <div class="php">
        @verbatim
            <p>
                For convenience, you may use the @checked directive to easily indicate if a given HTML checkbox input is "checked". This
                directive will echo checked if the provided condition evaluates to true
            </p>
            <p>
                Likewise, the @selected directive may be used to indicate if a given select option should be "selected"
            </p>
            <p>
                Additionally, the @disabled directive may be used to indicate if a given element should be "disabled"
            </p>
            <p>
                Moreover, the @readonly directive may be used to indicate if a given element should be "readonly"
            </p>
            <p>
                In addition, the @required directive may be used to indicate if a given element should be "required"
            </p>
        @endverbatim
        <form action="" method="get">
            <label for="name">Nama: </label>
            <input type="text" name="nama" id="name" @required(true)>
            <br>

            <label for="hobby">Hobi: </label>
            <input type="text" name="hobi" id="hobby" @required(false)>
            <br>

            <label for="status">Status: </label>
            <input type="text" name="status" id="status" value="Siswa" @disabled(true)>
            <br>

            <label for="date">Tanggal: </label>
            <input type="date" name="tanggal" id="date" @readonly(true)>
            <br>
            
            <input type="checkbox" name="menu1" id="makan1" value="Nasi Padang">
            <label for="makan1">Nasi Padang</label>
            <br>
            <input type="checkbox" name="menu2" id="makan2" value="Sate" @checked(true)>
            <label for="makan2">Sate</label>
            <br>
            <input type="checkbox" name="menu3" id="makan3" value="Nasi Kuning" @checked(false)>
            <label for="makan3">Nasi Kuning</label>
            <br>

            <select name="mobil" id="kendaraan">
                <option value="Honda" @selected(false)>Honda</option>
                <option value="Suzuki" @selected(true)>Suzuki</option>
                <option value="Toyota">Toyota</option>
            </select>

            <br>
            <button type="submit">Kirim</button>
        </form>
        <script>
            const date = document.forms[0].elements['date'];

            const time = new Date();
            const formatTime = time.getFullYear() + '-0' + (time.getMonth() + 1) + '-' + time.getDate();
            date.value = formatTime;
        </script>
    </div>

    <h2>6. Raw PHP</h2>
    <div class="php">
        <p>
            In some situations, it's useful to embed PHP code into your views. You can use the Blade @@php directive to execute a
            block of plain PHP within your template
        </p>
        @php
            var_dump($data);
            $count = 1;
            echo $count;
        @endphp
        <p>
            If you only need to write a single PHP statement, you can include the statement within the @@php directive
        </p>
        @php($waktu = time())
        {{ $waktu }}
    </div>

    <h2>7. Comments</h2>
    <div class="php">
        <p>
            Blade also allows you to define comments in your views. However, unlike HTML comments, Blade comments are not included
            in the HTML returned by your application
        </p>
        {{-- Teks ini tidak akan muncul dan tidak akan dirender oleh Laravel ke dalam HTML --}}
    </div>

</body>
</html>