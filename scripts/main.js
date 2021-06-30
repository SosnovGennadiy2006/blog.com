var show_more_posts_button = document.querySelector('.show_more');

this.scrollTo(0, page_y);

try
{
    show_more_posts_button.onclick = () => 
    {
        document.location.href = 'http://blog.com?n=' + (parseFloat(n) + 1) + '&pageY=' + pageYOffset;
    }
}catch(e){ }

function sleep(sec) {
    return new Promise((resolve, reject) => {
        setInterval(() => resolve(), sec);
    });
}

sleep(300).then(result => {
    var images = document.querySelectorAll('.lazy_load_img');

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    }

    function handleImg(myImg, observer) {
        myImg.forEach(myImgSingle => {
            if (myImgSingle.intersectionRatio > 0) {
                loadImage(myImgSingle.target);
            }
        })
    }

    function loadImage(image) {
        image.src = image.getAttribute('data-src');
    }

    const observer = new IntersectionObserver(handleImg, options);

    images.forEach(img => {
        observer.observe(img);
    })
})