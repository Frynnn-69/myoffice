import Navbar from "../components/Navbar";
import Hero from "../components/Hero";
import BrowseCity from "../wrappers/BrowseCityWrapper";
import Benefits from "../components/Benefits";
import BrowseOffice from "../wrappers/BrowseOfficeWrapper";
import Footer from "../components/Footer";

export default function Browse() {
  return (
    <>
      <Navbar/>
      <Hero/>
      <BrowseCity/>

      {/* <Benefits /> */}
      <section
        id="Benefits"
        className="flex items-center justify-center w-[1015px] mx-auto gap-[100px] mt-[100px]"
      >
        <h2 className="font-bold text-[32px] leading-[48px] text-nowrap">
          We Might Good <br />
          For Your Business
        </h2>
        <Benefits/>
      </section>

      <BrowseOffice/>
      <Footer/>
    </>
  );
}
