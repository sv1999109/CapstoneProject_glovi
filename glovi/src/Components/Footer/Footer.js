import React from "react";
import { TiSocialFacebook, TiSocialInstagram, TiSocialLinkedin, TiSocialTwitter, TiDevicePhone, TiMail, TiLocation } from 'react-icons/ti';
import './FooterStyle.css'


function Footer() {
    return (
        <>
            <footer>
                <section className="Footer Footersection">
                    <div className="FooterContent">
                        <h4>Blogs</h4>
                        <p>Palletizing your shipments is an art that, when done right, can streamline your shipping
                            process and maximize efficiency. Whether you're a business ow <a className='Blogreadmore' href="/Blogs">Read more</a></p>
                    </div>

                    <div className="FooterContent">
                        <h4>This Site</h4>
                        <li className="Footerli"><a>Tracking</a></li>
                        <li> <a href="/AboutUs">About</a> </li>
                        <li><a href="/Support">Help & Support</a></li>
                        <li><a href="/FAQ">FAQ</a></li>
                    </div>

                    <div className="FooterContent">
                        <h4>Contact Us</h4>
                        <p className="contact-input"><TiDevicePhone />+13068079974</p>
                        <p className="contact-input"><TiMail />no-reply@ansabooks.com</p>
                        <p className="contact-input"><TiLocation />Tallinn, Estonia: Regina, Canada</p>
                    </div>

                    <div className="FooterContent">
                        <h4>Follow Us</h4>
                        <div className="icons">
                            <a><TiSocialFacebook /></a>
                            <a><TiSocialInstagram /></a>
                            <a><TiSocialLinkedin /></a>
                            <a><TiSocialTwitter /></a>
                        </div>
                    </div>


                </section>

                <div className="Copyright">
                <hr className="line" />
                    <p>Copyright © {new Date().getFullYear()} Glovi by © ansabooks| All right reserved</p>
                </div>
            </footer>

        </>
    );
}

export default Footer