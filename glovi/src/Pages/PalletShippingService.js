import React from 'react';
import Header from '../Components/Header'
import Footer from '../Components/Footer'
import PalletImg from '../assets/PalletShippingService.svg'
import './ServicesStyle.css'

function Pallet() {
    return (
        <>
            <Header />
            <div className="Servicebody">
                <div className='Servicerow'>
                    <div className='Serviceimg'>
                        <img src={PalletImg} alt='Pallet_Image'/>
                    </div>

                    <div className='Servicecontentwrapper'>
                        <div className='Servicecontent'>
                            <h2>Pallet Shipping Service</h2>
                            <p>For bulk shipments or larger, heavier items, our Pallet Shipping Service provides the ideal solution. We
                                specialize in the secure transport of palletized goods, with a maximum weight capacity of up to 1000 kg.
                                Whether it's machinery parts, industrial equipment, or other bulk items, our service ensures the reliable
                                and efficient delivery of your shipments.</p>

                            <h3>Service Highlights:</h3>
                            <ul>
                                <li><b>Maximum Weight:</b> Up to 1000 kg</li>
                                <li><b>Examples of Items:</b> Machinery parts, Industrial equipment</li>                               
                            </ul>

                            <p>Benefit from cost-effective shipping solutions for your bulk goods, where safety and reliability are our top
                                 priorities.</p>
                        </div>
                    </div>

                </div>
            </div>

            <Footer />

        </>
    );
}

export default Pallet;
