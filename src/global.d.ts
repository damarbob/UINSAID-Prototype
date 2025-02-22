// global.d.ts

interface Element {
  getElementByDataAttr(attr: string, value: string): Element | null;
  getElementsByDataAttr(attr: string, value: string): NodeListOf<Element>;
  getDataAttribute(attr: string): string | null;
}

interface HTMLFormElement {
  encodeComponentMetaInputsToFormData(): FormData;
}

interface FormData {
  appendEncodedFormMetaInputs(name: string, form: HTMLFormElement): void;
}

interface Window {
  lang: string;
}