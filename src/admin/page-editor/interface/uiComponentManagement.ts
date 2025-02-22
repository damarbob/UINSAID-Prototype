// uiComponentManagement.ts

export default interface UiComponentManagement {
  loader: HTMLElement; // The loader element such as spinners or indefinite progress bars
  componentsTable: HTMLUListElement; // The table that contains the page components
  availableComponentsList: HTMLUListElement; // The list of available components
  componentsOrderInput: HTMLInputElement; // The hidden input that contains the order of the components
}
