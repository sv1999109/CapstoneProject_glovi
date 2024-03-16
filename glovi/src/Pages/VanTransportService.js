import React from 'react';
import Header from '../Components/Header'
import Footer from '../Components/Footer'
import VanImg from '../assets/VanTransportService.svg'
import './ServicesStyle.css'

function Van() {
    return (
        <>
            <Header />
            <div className="Servicebody">
                <div className='Servicerow'>
                    <div className='Serviceimg'>
                        <img src={VanImg} alt='Van_Image'/>
                    </div>

                    <div className='Servicecontentwrapper'>
                        <div className='Servicecontent'>
                            <h2>Van Transport Service</h2>
                            <p>Need to ship items that fit into a standard van? Our Van Transport Service is the answer. With flexible 
                                weight capacities based on van size, we handle everything from furniture to home appliances. Experience
                                 reliable and efficient shipping for your larger items, ensuring they reach their destination in perfect
                                  condition.</p>

                            <h3>Service Highlights:</h3>
                            <ul>
                                <li><b>Maximum Weight:</b> Varies by van size</li>
                                <li><b>Examples of Items:</b>Electrical Appliances,Home appliances,Fitness Equipment and Small Business
                                 Inventory</li>                               
                            </ul>

                            <p>Trust our Van Transport Service for the secure and timely delivery of your larger items, making the 
                                shipping process as smooth as possible.</p>
                        </div>
                    </div>

                </div>
            </div>

            <Footer />

        </>
    );
}

export default Van;
