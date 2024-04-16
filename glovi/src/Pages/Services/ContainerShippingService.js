import { React, useState, useEffect } from 'react';
import Header from '../../Components/Header/Header'
import Footer from '../../Components/Footer/Footer'
import ContainerImg from '../../assets/Container.png'
import './ServicesStyle.css'

function Container() {
    
    return (
        <>
            <Header />
            <div className="Servicebody">
                <div className='Servicerow'>
                    <div className='Serviceimg'>
                        <img src={ContainerImg} alt='Container_Image' />
                    </div>

                    <div className='Servicecontentwrapper'>
                        <div className='Servicecontent'>
                            <h2>Container Shipping Service</h2>
                            <p>For substantial shipments requiring cost-effective solutions, our Container Shipping Service is the
                                answer. With weight capacities varying by container size, we handle international trade goods and
                                manufacturing materials efficiently. Experience the ease of shipping in bulk with our dedicated
                                service, ensuring the secure and timely delivery of your large quantities.</p>

                            <h3>Service Highlights:</h3>
                            <ul>
                                <li><b>Maximum Weight:</b> Varies by container size</li>
                                <li><b>Examples of Items:</b> Goods for international trade, Manufacturing materials</li>
                            </ul>

                            <p>Navigate the complexities of international shipping with our Container Shipping Service, providing
                                comprehensive solutions for your bulk shipments.</p>
                        </div>
                    </div>

                </div>
            </div>

            <Footer />

        </>
    );
}

export default Container;
