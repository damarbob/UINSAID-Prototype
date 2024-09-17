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

function formatDate(timestamp) {
  // Check if timestamp is valid
  if (!timestamp || isNaN(new Date(timestamp).getTime())) {
    return "-";
  }

  // Convert timestamp to Date object
  const date = new Date(timestamp);

  // Convert Date object to Indonesian datetime string
  const options = {
    weekday: "short",
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "numeric",
    minute: "numeric",
    hour12: false,
    timeZone: "Asia/Jakarta", // Set the timezone to Indonesia
    timeZoneName: "short",
  };

  return new Intl.DateTimeFormat("id-ID", options).format(date);
}

function capitalizeFirstLetter(string) {
  if (!string || string.length === 0) {
    return ""; // Return an empty string if the input is null or empty
  }
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function getFilenameAndExtension(url) {
  if (url == null) {
    return "";
  }
  const filename = url.substring(url.lastIndexOf("/") + 1);
  return filename;
}
