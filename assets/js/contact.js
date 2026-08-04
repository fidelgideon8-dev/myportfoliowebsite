// Initialize EmailJS
emailjs.init({
    publicKey: "8ixrPgGmxdX9sXEA2",
});

const form = document.getElementById("contact-form");
const status = document.getElementById("status");

form.addEventListener("submit", function (e) {
    e.preventDefault();

    status.textContent = "Sending message...";
    status.style.color = "#333";

    emailjs.sendForm(
        "service_c63b7kf",
        "template_6dgrj2n",
        this
    )
    .then(() => {
        status.textContent = "✅ Thank you! Your message has been sent successfully.";
        status.style.color = "green";
        form.reset();
    })
    .catch((error) => {
        console.error("EmailJS Error:", error);
        status.textContent = "❌ Failed to send message. Please try again.";
        status.style.color = "red";
    });
});