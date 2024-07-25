// Konverter timestamp ke waktu dan tanggal format Indonesia
function timestampToIndonesianDateTime(timestamp) {
  // Convert timestamp to Date object
  const date = new Date(timestamp * 1000);

  // Convert Date object to Indonesian datetime string
  const options = {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "numeric",
    minute: "numeric",
    second: "numeric",
    hour12: false,
    timeZone: "Asia/Jakarta", // Set the timezone to Indonesia
  };

  const indonesianDateTime = date.toLocaleString("id-ID", options);
  return indonesianDateTime;
}
