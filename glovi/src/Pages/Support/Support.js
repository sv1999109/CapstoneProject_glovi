import React from 'react';
import Header from '../../Components/Header/Header'
import Footer from '../../Components/Footer/Footer'
import './SupportStyle.css'


function Support() {
    return (
        <>
            <Header />

            <div className='ContactBody'>
                <div className="Contactcontainer">

                    <h1 className="brand"><span>Send us an email</span></h1>

                    <div className="wrapper">
                        <div className="company-info">
                            <h3>Get in touch</h3>

                            <ul>
                                <li><i className="fa fa-road"></i> Tallinn, Estonia: Regina, Canada</li>
                                <li><i className="fa fa-phone"></i> +1(306)807-9974</li>
                                <li><i className="fa fa-envelope"></i> no-reply@ansabooks.com</li>
                            </ul>
                        </div>
                        <div className="contact">
                            <h3>Contact Form</h3>

                            <form id="contact-form">

                                <p>
                                    <label>Name</label>
                                    <input type="text" name="name" id="name" required />
                                </p>

                                <p>
                                    <label>E-mail</label>
                                    <input type="email" name="email" id="email" required />
                                </p>

                                <p>
                                    <label>Subject</label>
                                    <input  className="SupportSubject" ctype="text" name="Subject"  />
                                </p>

                                <p className="full">
                                    <label>Message</label>
                                    <textarea name="message" rows="5" id="message"></textarea>
                                </p>

                                <p className="full">
                                    <button type="submit">Submit</button>
                                </p>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <Footer />
        </>
    );
}

export default Support