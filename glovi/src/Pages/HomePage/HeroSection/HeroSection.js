import React, { useState, useEffect } from 'react';
import './hero.css'; // Import your CSS file for styling
import { TiArrowRight } from 'react-icons/ti'

export default function HeroSection() {
  const [contentIndex, setContentIndex] = useState(0);
  const [isAnimating, setIsAnimating] = useState(false);
  const [lastScrollPosition, setLastScrollPosition] = useState(0);
  const [allowScroll, setAllowScroll] = useState(true);

  useEffect(() => {
    const handleScroll = () => {
      const scrollPosition = window.scrollY;

      if (!isAnimating) {
        if (scrollPosition > lastScrollPosition && contentIndex < 2) {
          setContentIndex(contentIndex + 1);
          setIsAnimating(true);
          setAllowScroll(false); // Disable scrolling until all content is shown
        } else if (scrollPosition < lastScrollPosition && contentIndex > 0) {
          setContentIndex(contentIndex - 1);
          setIsAnimating(true);
          setAllowScroll(false); // Disable scrolling until all content is shown
        }
        else if(scrollPosition == lastScrollPosition){
          setContentIndex(0);
          setAllowScroll(true); 
       
        }
      }
      setLastScrollPosition(scrollPosition);
    };

    window.addEventListener('scroll', handleScroll);

    return () => {
      window.removeEventListener('scroll', handleScroll);
    };
  }, [contentIndex, isAnimating, lastScrollPosition]);

  useEffect(() => {
    // End animation after a short delay
    if (isAnimating) {
      setTimeout(() => {
        setIsAnimating(false);
        if (contentIndex === 1) {
          setAllowScroll(true); // Re-enable scrolling when all content is shown
        }
      }, 1000); // Adjust animation duration as needed
    }
  }, [isAnimating, contentIndex]);

  const content = [
    { heading: 'Trusted Carriers. Huge Savings.', description: 'Take advantage of our volume discounts and save big on your next shipment.', backgroundColor: 'rgb(219 217 255)', video: 'pink.mp4', image: 'brands.png',  paddingTop: "100px"},
    { heading: 'Instantly Know Everything', description: 'Birds eye view helps you instantly understand the location and transit status of all your packages.', backgroundColor: 'rgb(211 239 145)', video: 'green.mp4', image: 'green.png', paddingTop: "100px"},
    { heading: 'Instantly Know Everything', description: 'Birds eye view helps you instantly understand the location and transit status of all your packages.', backgroundColor: '#fad796', video: 'orange.mp4', image: 'orange.png', paddingTop: "150px"},
  ];

  const { heading, description, video, backgroundColor, image,paddingTop } = content[contentIndex];

  return (
    <>

  
    <section id="hero-section" style={{backgroundColor, paddingTop}}>
     <div style={{maxWidth: "80%"}} className=' h-auto  mx-auto flex justify-between items-center'>
      <div className='w-1/2 h-full' >
        <h1 style={{marginTop: "100px", color: "#36134a"}} className='text-6xl font-extrabold'>{heading}</h1>
     <p style={{width: "80%"}} className='text-xl my-6 ml-6 '>{description}</p>
      
      <img className='ml-6' src={image} alt="" />
      
      </div>
      <div className='w-1/2  h-full'>
      <video style={{width: "100%", marginTop: "130px"}} src={video} autoPlay loop muted alt="">Video Not Supported</video>


      </div>


     
     </div>
     <div style={{ maxWidth: "80%", borderRadius: "30px" }} className='bg-white mx-auto p-8 mt-10'>
    <h1 style={{ color: "#36134a" }} className='text-3xl font-bold mb-4'>Get Estimate</h1>
    <div className="flex flex-wrap justify-center items-center mb-4">
        <div className="flex flex-col mr-2 mb-4" style={{ width: "100%", maxWidth: "150px" }}>
            <input type="text" id="shipFrom" placeholder="Ship from" className="border border-gray-100 rounded px-3 py-2 relative" />
            


            
        </div>
        <TiArrowRight className='text-4xl mr-2 mb-3 '/>
        <div className="flex flex-col mr-5 mb-4" style={{ width: "100%", maxWidth: "150px" }}>
            <input type="text" id="shipTo" placeholder="Ship to" className="border border-gray-100 rounded px-3 py-2" />
        </div>
        <div className="flex flex-col mr-5 mb-4" style={{ width: "100%", maxWidth: "180px" }}>
            <select id="packageType" className="border border-gray-100 rounded px-3 py-2">
                <option value="">Package Type</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
                <option value="4">Option 4</option>
            </select>
        </div>
        <div className="flex flex-col mr-5 mb-4" style={{ width: "100%", maxWidth: "100px" }}>
            <input type="text" id="weight" placeholder="Weight" className="border border-gray-100 rounded px-3 py-2" />
        </div>
        <div className="flex flex-col mr-5 mb-4" style={{ width: "100%", maxWidth: "100px" }}>
            <select id="units" className="border border-gray-100 rounded px-3 py-2">
                <option value="">Select Units</option>
                <option value="kg">kg</option>
                <option value="lb">lb</option>
            </select>
        </div>
        <a href="#" className="text-orange-500 text-sm mr-5 mb-4 self-start">Advanced</a>
        <button className="bg-orange-500 text-white px-6 py-2 rounded mb-4">Get Estimate</button>
    </div>
</div>


    </section>
    </>
  );
}
