// formattingUseCase.ts

/**
 * Extracts the filename and extension from a file URL.
 * @param fileUrl - The file URL.
 */
export function getFilenameAndExtension(fileUrl: string): string {
  return fileUrl.split("/").pop() || fileUrl;
}
