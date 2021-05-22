// ambil elemen yang dibutuhkan
var keyword = document.getElementById('keyword');
var result = document.getElementById('result');

// tambahkan event ketika keyword ditulis
keyword.addEventListener('keyup', function(){
    
    // buat object ajax
    var xhr = new XMLHttpRequest();

    // cek kesiapan ajax
    xhr.onreadystatechange = function() {
        if( xhr.readyState == 4 && xhr.status == 200){
            result.innerHTML = xhr.responseText;
        }
    }

    // eksekusi ajax
    xhr.open('GET', 'ajax/result.php?keyword=' + keyword.value, true);
    xhr.send();
})