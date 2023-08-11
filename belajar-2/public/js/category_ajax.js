const search = document.querySelector('.form-control');
const content = document.querySelector('.isi');

search.addEventListener('input', searchQuery);

function searchQuery() {
    const xhr = new XMLHttpRequest();
    let data = JSON.stringify({
        query: search.value,
        category: window.location.href.split("/").pop()
    });

    xhr.addEventListener('load', function() {
            const hasil = JSON.parse(xhr.response).result;
            content.innerHTML = "";

            size = hasil.length;

            if(size === 0) {
                content.innerHTML = `
                    <div class="card-body d-flex justify-content-center">
                        <p class="m-0 text-secondary">
                            Kosong
                        </p>
                    </div>
                `;
            } else {
                for(let i = 0; i < size; i++) {
                    let value = hasil[i];

                    content.innerHTML += `
                        <div class="card-body">
                            <h3 class="card-title"><a href="/post/${value.post_slug}" class="text-decoration-none">${value.title}</a></h3>
                            <h6 class="card-subtitle text-body-secondary">Author: <a href="/author/${value.username}" class="text-decoration-none">${value.name}</a></h6>
                            <small class="mb-2 text-body-secondary">${value.updated_at}</small>
                            <p class="card-text">${value.excerpt}</p>
                            <a href="/post/${value.post_slug}" class="card-link">Read more</a>
                        </div>
                    `;

                    if(i + 1 !== size) {
                        content.innerHTML += "<hr>";
                    }


                }
            }
    });

    xhr.addEventListener("error", function() {
        content.innerHTML = `
            <div class="card-body d-flex justify-content-center">
                <p class="m-0 text-danger">
                    (Error) Something wrong :(
                </p>
            </div>
        `;
    });

    xhr.open("POST", "http://127.0.0.1:8000/search-post-category");

    xhr.setRequestHeader("content-type", "application/json");
    xhr.setRequestHeader("X-CSRF-TOKEN", token);

    xhr.send(data);
}