import PhotoSwipeLightbox from 'photoswipe/lightbox';

const lightbox = new PhotoSwipeLightbox({
    gallery: '#gallery-album',
    children: 'a',
    pswpModule: () => import('photoswipe')
});
lightbox.init();