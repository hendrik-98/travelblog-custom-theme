
document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.querySelectorAll('.play-button');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var videoId = this.getAttribute('data-video-id');
            var iframe = document.createElement('iframe');
            iframe.setAttribute('width', '560');
            iframe.setAttribute('height', '315');
            iframe.setAttribute('src', 'https://www.youtube.com/embed/' + videoId + '?autoplay=1');
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('allow', 'autoplay');
            var container = this.parentNode;
            container.innerHTML = '';
            container.appendChild(iframe);
        });
    });
});