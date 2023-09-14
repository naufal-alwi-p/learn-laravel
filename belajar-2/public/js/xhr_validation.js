const button = document.querySelector('#button-send');
const nama = document.querySelector('#name-input');
const email = document.querySelector('#email-input');
const box_output = document.querySelector('#box-result');
const form_card = document.querySelector('#form-card');
const output = document.querySelector('#json-display');
const hide_output = document.querySelector('#hide-btn')
const token = document.querySelector('input[type="hidden"]');
const protocolHostname = window.location.origin;

// Tidak bisa meng-copy teks apapun di dalam halaman ini
document.body.addEventListener('copy', function(e) {
    e.clipboardData.setData('text/plain', '');
    e.preventDefault();
});

button.addEventListener('click', () => {
    let data = JSON.stringify({
        name: nama.value,
        email: email.value
    });

    const xhrReq = fetch(protocolHostname + '/belajar-laravel/validation/xhr-validation', {
        method: "POST",
        headers: {
            "Accept": "application/json", // Bisa Gunakan Ini (Ini Lebih Utama)
            "X-Requested-With": "XMLHttpRequest", // Atau Gunakan Ini, Pilih Salah Satu. Nanti Jika Validation Laravel Error Maka Akan Merespon Balik Dengan JSON
            "Content-Type": "application/json;charset=utf-8",
            "X-CSRF-TOKEN": token.value
        },
        body: data
    });

    xhrReq.then(function(response) {
        console.clear();
        // if (!response.ok) {
        //     throw new Error(`Request Gagal (${response.status} ${response.statusText})`);
        // }
        console.log('bodyUsed:', response.bodyUsed);
        console.log('ok:', response.ok);
        console.log('redirected:', response.redirected);
        console.log('status:', response.status);
        console.log('statusText:', response.statusText);
        console.log('type:', response.type);
        console.log('url:', response.url);

        let hasil;

        if (response.status === 422) {
            hasil = response.json();
        } else {
            hasil = response.text();
        }

        console.log('bodyUsed:', response.bodyUsed);
        console.log('object hasil:', hasil);

        return hasil;
    }).then(function(hasil) {
        console.log("Hasil", hasil);
        if (hasil instanceof Object) {
            const alert = document.createElement("div");
            alert.setAttribute('role', 'alert');
            alert.setAttribute('class', 'alert alert-danger alert-dismissible fade show');
            
            alert.innerHTML += `Error: ${hasil.message}`;
            alert.innerHTML += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

            form_card.after(alert);
        } else {
            box_output.style.display = 'block';
            output.textContent = hasil;
        }
    }).catch(function(error) {
        console.log(error);
    });
});

hide_output.addEventListener('click', function() {
    box_output.style.display = 'none';
});