const formCollection = document.forms.item(0).elements;

const formArray = Array.from(formCollection).filter((element) => {
    return (element.name !== "_token" && element.name !== "opsi" && element.type !== "submit");
});

const data = formCollection.namedItem('data');
const dataConfirmation = formCollection.namedItem('data_confirmation');
const cek = formCollection.namedItem('cek');
const opsi = formCollection.namedItem('opsi');
const file = formCollection.namedItem('file_upload');

window.addEventListener('load', validationHelper);
opsi.addEventListener('change', validationHelper);

/* ----------------------- Validation ----------------------- */
function validationHelper() {
    returnToDefault(formArray);

    switch (opsi.value) {
        case "accepted":
            data.disabled = true;
            data.parentElement.style.display = "none";

            cek.disabled = false;
            cek.parentElement.style.display = "block";
            break;
        case "accepted_if":
            cek.disabled = false;
            cek.parentElement.style.display = "block";
            break;
        case "array":
            data.value = JSON.stringify({
                makanan: ['nasi goreng', 'ketoprak'],
                minuman: ['teh', 'jus']
            });
            break;
        case "size(array)":
            data.value = JSON.stringify({
                makanan: ['nasi goreng', 'ketoprak'],
                minuman: ['teh', 'jus'],
                tahu: 'sumedang',
                rumah: "padang"
            });
            break;
        case "between(file)":
        case "dimensions":
        case "mimetypes":
            data.disabled = true;
            data.parentElement.style.display = 'none';

            file.disabled = false;
            file.parentElement.style.display = 'block';
            break;
        case "confirmed":
        case "same":
        case "unique":
            dataConfirmation.disabled = false;
            dataConfirmation.parentElement.style.display = 'block';
            break;
        case "conditionally adding rules":
            data.value = JSON.stringify({
                teh: {
                    varian: "biasa",
                    harga: 2000
                },
                "jus alpukat": {
                    varian: "ekslusif",
                    harga: 20000
                },
                "teh tarik": {
                    varian: "ekslusif",
                    harga: 15000
                }
            });
            
            dataConfirmation.disabled = false;
            dataConfirmation.parentElement.style.display = 'block';

            cek.disabled = false;
            cek.parentElement.style.display = 'block';

            file.disabled = false;
            file.parentElement.style.display = 'block';
            break;
        case "required_array_keys":
            data.value = JSON.stringify({
                nama: "Dani",
                umur: 22,
                data_diri: {
                    "tinggi badan": 183,
                    "berat badan": 78
                }
            });
            break;
        case "validating arrays":
            data.value = JSON.stringify({
                nama: "Dani",
                umur: 25,
                data_diri: {
                    tinggi_badan: 176,
                    berat_badan: 78
                },
                makanan: "Nasi Goreng",
                tahu: "ada"
            });

            dataConfirmation.disabled = false;
            dataConfirmation.parentElement.style.display = 'block';

            dataConfirmation.value = JSON.stringify({
                username: "dark_nights",
                makanan: {
                    pesanan: ['Nasi', 'Sayur Bayem', 'Ikan Teri'],
                    harga: 20000
                },
                minuman: {
                    pesanan: ['Teh', 'Jus Alpukat'],
                    harga: 17000
                },
                info: {
                    laptop: {
                        merk: "Asus",
                        processor: "Intel"
                    },
                    smartphone: {
                        merk: "Vivo",
                        processor: "Mediatek"
                    },
                    os: ['Windows', 'Linux']
                },
                news: [
                    {
                        headline: "Tes 1",
                        views: 100
                    },
                    {
                        headline: "Tes 2",
                        views: 79
                    }
                ]
            });
            break;
        case "validating files":
            data.disabled = true;
            data.parentElement.style.display = 'none';

            file.disabled = false;
            file.parentElement.style.display = 'block';
            break;
        case "custom validation rules":
            dataConfirmation.disabled = false;
            dataConfirmation.parentElement.style.display = 'block';
            break;
        case "default":
        case "active_url":
        case "after":
        case "alpha":
        case "alpha_dash":
        case "alpha_num":
        case "ascii":
        case "bail":
        case "size(string)":
        case "size(numeric)":
        case "decimal":
        case "digit":
        case "exists":
        case "in":
        case "ipv6":
        case "multiple_of":
        case "validating passwords":
            break;
        default:
            console.log("Option is Not Valid");
    }
}
/* ----------------------- Validation ----------------------- */

function returnToDefault(array) {
    for (let element of array) {
        if (element.name === "data") {
            element.disabled = false;
            element.parentElement.style.display = "block";

            continue;
        }

        element.disabled = true;
        element.parentElement.style.display = "none";
    }
}