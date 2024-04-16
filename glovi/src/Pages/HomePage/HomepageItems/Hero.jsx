import React from 'react'
import { TiArrowRight } from 'react-icons/ti'
import Header from '../../../Components/Header/Header'

export default function Hero() {
  return (
    <>
  <Header/>
    <section id="primary_hero">
     <div style={{maxWidth: "60%"}} className=' h-auto  mx-auto flex justify-between items-center'>
      <div className='w-1/2 h-full' >
        <h1 style={{marginTop: "130px", color: "#36134a"}} className='text-5xl font-extrabold'>Trusted Carriers. <br/> Huge Savings.</h1>
     <p style={{width: "70%"}} className='text-xl my-6 '>Take advantage of our volume discounts and save big on your next shipment.</p>
      
      <img src="brands.png" alt="" />
      
      </div>
      <div className='w-1/2  h-full'>
      <img style={{width: "100%", marginTop: "130px"}} src="header.png" alt="" />
      </div>


     
     </div>
     <div style={{ maxWidth: "60%", borderRadius: "30px" }} className='bg-white mx-auto p-8'>
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

  )
}
