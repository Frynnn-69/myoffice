export default function Footer() {
  return (
    <footer className="bg-white">
      <div className="w-full max-w-[1130px] mx-auto py-[30px]">
        {/* Flexbox Layout */}
        <div className="flex flex-wrap justify-between gap-12">
          {/* Company Info */}
          <div className="flex-1 min-w-[250px]">
            <div className="mb-[20px] flex items-center">
              <a href="index.html">
                <img src="/assets/images/logos/logo.svg" alt="logo" />
              </a>
            </div>
            {/* <p className="text-gray-600 text-sm mb-6">
              Your trusted platform for finding and booking the best experiences.
            </p> */}
          </div>

          {/* Quick Links */}
          <div className="flex-1 min-w-[250px]">
            <h4 className="font-bold text-lg mb-6">Quick Links</h4>
            <ul className="space-y-4">
              <li><a href="#" className="text-gray-600 hover:text-gray-900">Browse</a></li>
              <li><a href="#" className="text-gray-600 hover:text-gray-900">Popular</a></li>
              <li><a href="#" className="text-gray-600 hover:text-gray-900">Categories</a></li>
              <li><a href="#" className="text-gray-600 hover:text-gray-900">Events</a></li>
            </ul>
          </div>

          {/* Help & Support */}
          <div className="flex-1 min-w-[250px]">
            <h4 className="font-bold text-lg mb-6">Help & Support</h4>
            <ul className="space-y-4">
              <li><a href="#" className="text-gray-600 hover:text-gray-900">FAQs</a></li>
              <li><a href="#" className="text-gray-600 hover:text-gray-900">Contact Us</a></li>
              <li><a href="#" className="text-gray-600 hover:text-gray-900">Terms of Service</a></li>
              <li><a href="#" className="text-gray-600 hover:text-gray-900">Privacy Policy</a></li>
            </ul>
          </div>

          {/* Contact Information */}
          <div className="flex-1 min-w-[250px]">
            <h4 className="font-bold text-lg mb-6">Get in Touch</h4>
            <div className="space-y-4">
              <div className="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span className="text-gray-600">info@example.com</span>
              </div>
              <div className="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span className="text-gray-600">+1 234 567 890</span>
              </div>
              <div className="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span className="text-gray-600">123 Street, City, Country</span>
              </div>
            </div>
          </div>
        </div>

        {/* Social Media Icons */}
        <div className="flex justify-center gap-6 my-12 mb-16">
          <a href="#" className="bg-gray-200 p-3 rounded-full hover:bg-gray-300">
            {/* Facebook Icon */}
          </a>
          <a href="#" className="bg-gray-200 p-3 rounded-full hover:bg-gray-300">
            {/* Twitter Icon */}
          </a>
          <a href="#" className="bg-gray-200 p-3 rounded-full hover:bg-gray-300">
            {/* Instagram Icon */}
          </a>
          <a href="#" className="bg-gray-200 p-3 rounded-full hover:bg-gray-300">
            {/* LinkedIn Icon */}
          </a>
        </div>

        {/* Copyright */}
        <div className="border-t border-gray-200 pt-[50px] text-center">
          <p className="text-sm text-gray-500">
            © {new Date().getFullYear()} Your Company Name. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  );
}
