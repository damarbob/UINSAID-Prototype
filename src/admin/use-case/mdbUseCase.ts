// mdbUseCase.ts

// @ts-ignore
import * as mdb from "mdb-ui-kit"; // Material Design

/**
 * Reinitializes MDB elements after creating inputs.
 */
export function reinitializeMDBElements(container: HTMLElement): void {
  // Reinitialize MDB components if necessary

  // Re-initialize MDB input fields (for floating labels)
  if (typeof mdb !== "undefined" && mdb.Input) {
    container.querySelectorAll(".form-outline").forEach((element) => {
      const inputInstance = new mdb.Input(element);
      inputInstance.update(); // Update the input state to handle floating labels
    });
  }

  // Re-initialize MDB range inputs
  if (typeof mdb !== "undefined" && mdb.Range) {
    container.querySelectorAll(".range").forEach((element) => {
      new mdb.Range(element); // Initialize range inputs
    });
  }

  // Add other MDB component initializations if needed
}
