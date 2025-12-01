import Quill from 'quill';

document.addEventListener('alpine:init', () => {
    Alpine.data('invoiceEditor', (initialItems = [], initialCurrency = 'DZD', initialDiscount = 0, initialTvaRate = 19, initialTvaEnabled = true) => ({
        items: initialItems.length > 0 ? initialItems : [{ name: '', quantity: 1, rate: 0 }],
        currency: initialCurrency,
        discount: initialDiscount,
        tvaRate: initialTvaRate,
        tvaEnabled: initialTvaEnabled,

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
            if (!this.tvaEnabled) return 0;
            return Math.max(0, (this.subtotal - this.discount) * (this.tvaRate / 100)).toFixed(2);
        },

        get total() {
            const subtotalAfterDiscount = Math.max(0, this.subtotal - this.discount);
            if (!this.tvaEnabled) return subtotalAfterDiscount.toFixed(2);
            return (subtotalAfterDiscount * (1 + this.tvaRate / 100)).toFixed(2);
        },

        initQuill(el, index) {
            const quill = new Quill(el, {
                theme: 'snow',
                modules: {
                    toolbar: [['bold', 'italic', 'underline'], [{ 'list': 'ordered' }, { 'list': 'bullet' }]]
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
