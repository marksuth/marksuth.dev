import EasyMDE from 'easymde';

const easyMDE = new EasyMDE({
    element: document.getElementById('content'),
    spellChecker: false,
    inputStyle: 'contenteditable',
});
