import React, { useState } from "react";
import Header from '../../Components/Header/Header'
import Footer from '../../Components/Footer/Footer'
import AboutUs from '../../assets/About.png'
import Mission from '../../assets/Mission.jpg'
import './AboutStyle.css'


function About() {

    const [popupActive, setPopupActive] = useState(false);
    const [popupContent, setPopupContent] = useState(null);

    function togglePopup(content) {
        setPopupContent(content);
        setPopupActive(!popupActive);
    }

    return (
        <>
            <Header />
            
            <div className="we-are-block">

                <div id="about-us-section">
                    <div className="about-us-info">

                        <h2>About Glovi</h2>

                        <p>Welcome to Glovi, where innovation meets convenience in the world of global shipping. Established with a vision to simplify and enhance the shipping experience for individuals and businesses alike, Glovi is your trusted partner in delivering a seamless, reliable, and cost-effective shipping solution.</p>

                        <a href="#" onClick={() => togglePopup(<PopupContent1 />)} title="About Us Button">ABOUT US</a>

                    </div>

                    <div className="about-us-image">

                        <img src={AboutUs} style={{ width: "834px", height: "100%", maxWidth: "-webkit-fill-available" }} alt="Lobby Image" />

                    </div>




                </div>

                <div id="history-section">
                    <div className="history-image">

                        <img src={Mission} width="951" height="471" alt="Building Pic" />

                    </div>


                    <div className="history-info">

                        <h2>Our Mission</h2>
                        <p>At Glovi, our mission is to redefine the way you send and receive packages across the globe.
                            We believe that shipping should be easy, transparent, and accessible to everyone. Whether you're a small business expanding internationally or an individual sending a thoughtful gift to a loved one, Glovi is here to make your shipping experience smooth and stress-free.</p>
                    </div>

                </div>

            </div>
            {popupActive && (
                <div className="Aboutpopup" id="popup-1">
                    <div className="overlay" onClick={() => setPopupActive(false)}>
                        <div className="popContent">
                            <div className="close-btn">
                                &times;
                            </div>
                            {popupContent}
                        </div>
                    </div>
                </div>
            )}
            <Footer />
        </>
    )
}

const PopupContent1 = () => (
    <div className="">
        <h1 className="Popup1-Heading">About US</h1>

        <div className='aboutInnerContainer'>

            <div className="scrollable-contentAbout">

                <h2 style={{fontWeight:"bold"}}>About Glovi</h2>
                <p className='AboutText'>Welcome to Glovi, where innovation meets convenience in the world of global shipping.
                    Established with a vision to simplify and enhance the shipping experience for individuals and businesses alike,
                    Glovi is your trusted partner in delivering a seamless, reliable, and cost-effective shipping solution.</p>


                <h2 style={{fontWeight:"bold"}}>Our Mission</h2>
                <p className='AboutText'>At Glovi, our mission is to redefine the way you send and receive packages across
                    the globe. We believe that shipping should be easy, transparent, and accessible to everyone. Whether
                    you're a small business expanding internationally or an individual sending a thoughtful gift to a loved
                    one, Glovi is here to make your shipping experience smooth and stress-free.</p>

                <h2 style={{fontWeight:"bold"}}>What Sets Us Apart</h2>
                <span>Multi-Carrier Expertise</span>
                <p className='AboutText'>Glovi stands out with its expertise in multi-carrier shipping solutions. We've
                    partnered with leading carriers worldwide to offer you a diverse range of shipping options. From documents
                    and parcels to pallets, vans, trucks, and containers, we have tailored services to meet your unique shipping
                    needs.</p>


                <span>User-Friendly Platform</span>
                <p className='AboutText'>Navigating the complexities of shipping is now a breeze with our user-friendly platform.
                    Easily compare prices, choose the best shipping option, and track your packages—all in one place. Our intuitive
                    interface ensures that whether you're a shipping novice or a seasoned pro, Glovi provides a hassle-free
                    experience.</p>

                <span >Global Reach, Local Touch</span>
                <p className='AboutText'>With a global network of partners, Glovi ensures that your shipments reach their
                    destination, no matter how near or far. We combine our global reach with a local touch, understanding the unique
                    requirements of different regions to provide a personalized shipping experience.</p>


                <h2>Our Commitment to You</h2>
                <span>Reliability</span>
                <p className='AboutText'>Trust is the cornerstone of our service. We understand the importance of your shipments,
                    and our commitment to reliability means that you can depend on Glovi to deliver on time, every time.</p>


                <span>Affordability</span>
                <p className='AboutText'>Shipping should be affordable without compromising on quality. Glovi is dedicated to
                    providing cost-effective solutions, ensuring that you get the best value for your shipping needs.</p>

                <span>Innovation</span>
                <p className='AboutText'>In a rapidly evolving world, innovation is key. Glovi is at the forefront of
                    technological advancements in the shipping industry, constantly seeking new ways to improve and optimize our
                    services.</p>


                <h2>Join the Glovi Community</h2>
                <p className='AboutText'>Whether you're a small business owner, an e-commerce enthusiast, or someone sending
                    a heartfelt package, Glovi invites you to join our growing community of satisfied customers. Experience
                    shipping made easy with Glovi—where your parcels are not just packages; they're expressions, connections,
                    and moments reaching across the globe.</p>
                <p className='AboutText'>
                    Thank you for choosing Glovi as your shipping partner. We look forward to serving you on your shipping journey.
                </p>

                <h2>Glovi - Shipping Simplified, Globally Connected.</h2>
            </div>
        </div>
    </div>
);


export default About;