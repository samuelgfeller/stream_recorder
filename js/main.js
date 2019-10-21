

document.getElementById('videoNameInput').addEventListener("keyup", filter);

function filter()
{
    let input = document.getElementById('videoNameInput').value.toUpperCase();
    let container = document.getElementById('thumbnailContainer');
    let thumbnails = container.getElementsByClassName('thumbnail');

    for (let i = 0; i < thumbnails.length; i++) {
        // Get (first) p below i'th thumbnail
        let p = thumbnails[i].getElementsByTagName('p')[0];
        let txtValue = p.textContent || p.innerText;
        if (txtValue.toUpperCase().indexOf(input) > -1) {
            thumbnails[i].style.display = "";
        } else {
            thumbnails[i].style.display = "none";
        }
    }
}

