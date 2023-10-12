import './bootstrap';
import Editor from '@toast-ui/editor'
import '@toast-ui/editor/dist/toastui-editor.css';

document.addEventListener('livewire:init', () => {
    if( document.getElementById("editor") ){
        const editor = new Editor({
            el: document.querySelector('#editor'),
            previewStyle: 'vertical',
            height: '500px',
            events: {
                change: function(body,a) {
                    alert(a);
                }
            },
            initialValue: ''
        });
    }
});
