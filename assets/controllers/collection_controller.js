import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['list', 'item', 'template'];
    static values = { index: Number };

    add(event) {
        event.preventDefault();

        const clone = document.importNode(this.templateTarget.content, true);
        const row = clone.querySelector('[data-collection-target="item"]');

        row.innerHTML = row.innerHTML.replace(/__name__/g, this.indexValue);
        this.indexValue++;

        this.listTarget.appendChild(row);
    }

    remove(event) {
        event.preventDefault();
        event.target.closest('[data-collection-target="item"]').remove();
    }
}
