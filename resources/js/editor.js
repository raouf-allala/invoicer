import Quill from 'quill';

document.addEventListener('alpine:init', () => {
    Alpine.data('invoiceEditor', (initialItems = []) => ({
        items: initialItems.length > 0 ? initialItems : [{ name: '', quantity: 1, rate: 0 }],
        
        init() {
            // Initialize Quill for existing items if any (handled by x-init on the element)
        },

        addItem() {
            this.items.push({ name: '', quantity: 1, rate: 0 });
        },

        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },

        calculateTotal(item) {
            return (item.quantity * item.rate).toFixed(2);
        },

        get subtotal() {
            return this.items.reduce((sum, item) => sum + (item.quantity * item.rate), 0).toFixed(2);
        },

        get tax() {
            return (this.subtotal * 0.19).toFixed(2);
        },

        get total() {
            return (this.subtotal * 1.19).toFixed(2);
        },
        
        initQuill(el, index) {
            const quill = new Quill(el, {
                theme: 'snow',
                modules: {
                    toolbar: [['bold', 'italic', 'underline'], [{ 'list': 'ordered'}, { 'list': 'bullet' }]]
                },
                placeholder: 'Désignation...'
            });

            // Set initial content
            if (this.items[index].name) {
                quill.root.innerHTML = this.items[index].name;
            }

            // Update model on change
            quill.on('text-change', () => {
                this.items[index].name = quill.root.innerHTML;
            });
        }
    }));
});
