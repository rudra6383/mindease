// Appointment form submission logic (Just for demonstration)
document.getElementById('appointmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;
    
    if (name && email && message) {
        alert('Your appointment request has been submitted! We will get back to you soon.');
    } else {
        alert('Please fill out all fields.');
    }
});


// JavaScript to make the testimonial slideshow work
let testimonialIndex = 0;
showTestimonials();

function showTestimonials() {
    let testimonials = document.getElementsByClassName("mySlides");
    
    // Hide all testimonials initially
    for (let i = 0; i < testimonials.length; i++) {
        testimonials[i].style.display = "none";  
    }
    
    // Increment testimonial index and loop back to 1 if we exceed the number of testimonials
    testimonialIndex++;
    if (testimonialIndex > testimonials.length) {testimonialIndex = 1}    

    // Display the current testimonial
    testimonials[testimonialIndex-1].style.display = "block";  

    // Change testimonial every 10 seconds
    setTimeout(showTestimonials, 10000);
}
