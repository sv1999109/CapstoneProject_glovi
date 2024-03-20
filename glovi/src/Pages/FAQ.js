import React from "react";
import Header from '../Components/Header'
import Footer from '../Components/Footer'
import { FaAngleDown } from 'react-icons/fa';
import FaqImg from '../assets/Faq.jpg'
import './FaqStyle.css'
import { useState } from 'react';

function FAQ() {

    const [openIndex, setOpenIndex] = useState(null);

    const toggleAccordion = (index) => {
        setOpenIndex(openIndex === index ? null : index);
    };

    return (
        <>
            <Header />
            <div id="Faq_body">
                <div className="FaqAccordion">
                    <div className="FaqImgbox">
                        <img src={FaqImg} alt="FaqImg" />
                    </div>

                    <div className="FaqAccordionText">
                        <div className="Fag_Title">Frequently Asked Questions</div>
                        <ul className="FaqText">
                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(1)}>
                                    <span className="question">1. What is Glovi?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 1 ? 'show' : 'hide'}>Glovi is a comprehensive global courier delivery platform that connects users with a network of 85+
                                    carriers, covering Europe, USA, Canada, Australia, and the rest of the world. It facilitates
                                    seamless and reliable international shipping and delivery services for businesses and individuals.</p>
                                <span className="Faqline"></span>
                            </li>


                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(2)}>
                                    <span className="question">2. How does Glovi work?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 2 ? 'show' : 'hide'}>Glovi simplifies the shipping process by providing a user-friendly platform. Users can enter shipment
                                    details, choose from a variety of carriers, and track their packages in real-time. The platform
                                    ensures efficient and secure delivery from the sender to the recipient.</p>
                                <span className="Faqline"></span>
                            </li>

                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(3)}>
                                    <span className="question">3. What regions does Glovi cover?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 3 ? 'show' : 'hide'}>Glovi covers a vast network of regions, including Europe, USA, Canada, Australia, and other
                                    international destinations. With 85+ carriers, Glovi offers a broad reach to meet the diverse
                                    shipping needs of its users.</p>
                                <span className="Faqline"></span>
                            </li>

                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(4)}>
                                    <span className="question">4. Can I track my shipment in real-time?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 4 ? 'show' : 'hide'}>Yes, Glovi provides a robust tracking system that allows users to monitor their shipments in real-time.
                                    Once your package is in transit, you can easily track its journey and receive timely updates on its
                                    location and estimated delivery time.</p>
                                <span className="Faqline"></span>
                            </li>


                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(5)}>
                                    <span className="question">5. How can I choose the best carrier for my shipment?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 5 ? 'show' : 'hide'}>Glovi offers a variety of carriers, each with its own set of features and pricing. The platform
                                    provides detailed information about each carrier, including delivery times, costs, and customer
                                    reviews. Users can make informed decisions based on their specific requirements.</p>
                                <span className="Faqline"></span>
                            </li>


                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(6)}>
                                    <span className="question">6. Are there any customs considerations for international shipments?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 6 ? 'show' : 'hide'}>Yes, Glovi provides guidance on customs documentation and requirements for international shipments.
                                    It is crucial to provide accurate information and comply with customs regulations to ensure smooth
                                    clearance and delivery.</p>
                                <span className="Faqline"></span>
                            </li>


                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(7)}> 
                                    <span className="question">7. What payment options are available on Glovi?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 7 ? 'show' : 'hide'}>Glovi accepts a range of payment methods, including credit cards, debit cards, and other secure
                                    online payment options. The platform prioritizes user convenience and security in all transactions.</p>
                                <span className="Faqline"></span>
                            </li>


                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(8)}>
                                    <span className="question">8. How does Glovi ensure the security of my shipments?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 8 ? 'show' : 'hide'}>Glovi prioritizes the security and integrity of shipments. The platform collaborates with reputable carriers,
                                    and each shipment is tracked and monitored to prevent loss or damage. Users can also opt for additional
                                    insurance coverage for added peace of mind.</p>
                                <span className="Faqline"></span>
                            </li>


                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(9)}>
                                    <span className="question">9. What should I do if there is an issue with my shipment?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 9 ? 'show' : 'hide'}>In case of any issues or concerns with your shipment, Glovi provides a dedicated customer support team
                                    to assist you. Users can reach out through the platform for prompt and efficient resolution of any problems.</p>
                                <span className="Faqline"></span>
                            </li>

                            <li className="FaqList">
                                <div className="question-arrow" onClick={() => toggleAccordion(10)}>
                                    <span className="question">10. How can I sign up for Glovi?</span>
                                    <FaAngleDown />
                                </div>
                                <p className={openIndex === 10 ? 'show' : 'hide'}>Signing up for Glovi is easy and free. Visit the Glovi website, create an account, and start utilizing
                                    the platform to meet your global shipping needs seamlessly.</p>
                                <span className="Faqline"></span>
                            </li>
                        </ul>
                    </div>
                </div>

                
            </div>
            <Footer />
        </>
    )
}

export default FAQ