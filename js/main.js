

document.getElementById('videoNameInput').addEventListener("keyup", filter);

function filter()
{
    let input = document.getElementById('videoNameInput').value.toUpperCase();
    let container = document.getElementById('thumbnailContainer');
    let thumbnails = container.getElementsByClassName('thumbnail');

    for (let i = 0; i < thumbnails.length; i++) {
        // Get (first) span below i'th span
        let span = thumbnails[i].getElementsByTagName('span')[0];
        let txtValue = span.textContent || span.innerText;
        if (txtValue.toUpperCase().indexOf(input) > -1) {
            thumbnails[i].style.display = "";
        } else {
            thumbnails[i].style.display = "none";
        }
    }
}

