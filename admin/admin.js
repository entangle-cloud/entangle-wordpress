window.addEventListener("DOMContentLoaded", async () => {
  const url = "https://hicafe.co/vibecheck";
  const uuid = entangleAdmin.uuid;
  const splitUuid = new URL(uuid).pathname.split("/").pop().replace(".js", "");
  try {
    if (uuid.trim().length === 0) return;
    const response = await fetch(url, {
      method: "POST",
      headers: { "content-type": "application/json" },
      body: JSON.stringify({
        uuid: splitUuid,
      }),
    });
    if (!response.ok) {
      document.getElementById("notification").style.display = "block";
      document.getElementById("notification").innerHTML =
        "<p><strong>Please request your Entangle keys by visiting: </strong><a href='https://entangle.cloud/contact' target='_blank'>https://entangle.cloud/contact</a></p>";
    }
  } catch (error) {
    document.getElementById("notification").style.display = "block";
    document.getElementById("notification").innerHTML =
      "<p><strong>Please request your Entangle keys by visiting: </strong><a href='https://entangle.cloud/contact' target='_blank'>https://entangle.cloud/contact</a></p>";
  }
});
