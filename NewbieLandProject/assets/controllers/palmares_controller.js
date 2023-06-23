import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static values = {
    prototype: String,
    index: Number
  };

  static targets = ['fields', 'field', 'addBtn'];
  connect() {
    console.log("form-collection connected");
    this.index = this.fieldTargets.length;
  }

  addItem() {
    let prototype = JSON.parse(this.prototypeValue);
    prototype = prototype.replace(/__name__/g, this.index);
    this.index++;
    this.fieldsTarget.insertAdjacentHTML('beforeend', prototype);
  }

  removeItem(event) {
    this.fieldTargets.forEach((field) => {
      if (field.contains(event.target)) {
        field.remove();
      }
    });
  }
}
