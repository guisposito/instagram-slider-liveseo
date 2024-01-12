// slider-config.js
jQuery(document).ready(function ($) {
    if (typeof $ !== 'undefined' && $.fn.jquery) {
        // jQuery está carregado, podemos usar o $ com segurança
        $.ajax({
            url: instagram_feed_params.rest_url + 'instagram/v1/posts',
            method: "GET",
            success: function (data) {
                data.forEach(function (post) {
                    var postHtml = '<div class="glider-instagram-post">';
                    postHtml += '<a href="' + post.permalink + '" target="_blank">';
                    postHtml +=
                        '<img loading="lazy" width="231" height="231" src="' +
                        post.media_url +
                        '" alt="Instagram Post">';
                    postHtml += "</a>";
                    postHtml += "</div>";
                    $(".glider-instagram").append(postHtml);
                });

                // Inicialização do Glider.js
                window._glider = new Glider(document.querySelector('.glider-instagram'), {
                    slidesToShow: 1.5,
                    slidesToScroll: 1,
                    itemWidth: 223,
                    arrows:false,
                    draggable: true,
                    dots: false,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 'auto',
                                slidesToScroll: 'auto',
                                draggable: true,
                                itemWidth: 231,
                                arrows: {
                                    prev: '.glider-prev',
                                    next: '.glider-next'
                                }
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 'auto',
                                slidesToScroll: 'auto',
                                draggable: true,
                                itemWidth: 231
                            },
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 'auto',
                                slidesToScroll: 'auto',
                                draggable: true,
                                dots: false,
                                itemWidth: 231
                            },
                        },
                    ],
                });
            },
            error: function (error) {
                console.log("Erro ao buscar dados do Instagram: " + error);
            },
        });
    } else {
        // jQuery não está carregado corretamente
        console.error('jQuery não está carregado corretamente.');
    }
});
