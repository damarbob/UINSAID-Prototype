import ComponentData from "./componentData";

export default interface ComponentMetaData {
    componentData: ComponentData, // The original component data
    instanceId: string,
    componentId: string,
    pageId: string,
    meta: string | null, // The meta value for the component (e.g. "Page Title", "About Us", etc.) in JSON format
}