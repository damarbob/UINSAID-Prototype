// Template for data taken from the component list
export default interface ComponentData {
    id: string,
    name: string,
    content: string | null,
    meta: string | null, // The meta data for the component (e.g. "title", "description", etc.) in JSON format
    singular: string;
  }