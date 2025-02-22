// searchComponent.js

export default class ComponentSearch {
  private searchComponent;
  constructor(searchComponent: HTMLInputElement) {
    this.searchComponent = searchComponent;
    this.initializeSearch();
  }
  initializeSearch() {
    this.searchComponent.addEventListener("input", function () {
      const input = this.value.toLowerCase(); // Get the input value
      const listItems: NodeListOf<HTMLLIElement> =
        document.querySelectorAll("#daftarKomponen li"); // Get all list items

      listItems.forEach(function (item) {
        const componentName = item.getAttribute("data-name")?.toLowerCase(); // Get the name attribute
        item.style.display = componentName?.includes(input) ? "" : "none"; // Show or hide items
      });
    });
  }
}
