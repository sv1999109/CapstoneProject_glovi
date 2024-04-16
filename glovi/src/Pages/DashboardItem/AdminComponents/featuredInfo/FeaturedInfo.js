import { ArrowDownward, ArrowUpward } from "@mui/icons-material";
import { useEffect, useState } from "react";
import { FaDollarSign, FaShoppingCart, FaMoneyBillWave } from "react-icons/fa";

export default function FeaturedInfo() {


  let income = 0;
  let perc = 0.00;
  let todayIncome = 3;
  let percentage = 0.00;


  return (
    <div className="grid grid-cols-1  sm:grid-cols-2 md:grid-cols-4 gap-6">
      <div style={{boxShadow: "rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset"}} className="p-6 bg-pink-800 rounded-lg shadow-md text-white">
        <div className="flex items-center justify-between">
        <span className="text-sm font-medium uppercase">Shipments</span>
          <FaShoppingCart className="w-6 h-6" />
        </div>
        <div className="flex items-center mt-2">
        <span className="text-3xl font-semibold">${todayIncome}</span>
        <span className={`ml-2 px-2.5 py-0.5 text-sm font-medium rounded-full ${percentage < 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'}`}>
            %{Math.floor(Math.abs(percentage))}
            {percentage < 0 ? (
              <ArrowDownward className="w-5 h-5" />
            ) : (
              <ArrowUpward className="w-5 h-5" />
            )}
          </span>
        </div>
        
      </div>
      <div style={{boxShadow: "rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset"}} className="p-6 bg-gray-700 rounded-lg shadow-md text-white">
        <div className="flex items-center justify-between">
        <span className="text-sm font-medium uppercase">Pending</span>
          <FaMoneyBillWave className="w-6 h-6" />
        </div>
        <div  className="flex items-center mt-2">
          <span className="text-3xl font-semibold">${income}</span>
          <span className={`ml-2 px-2.5 py-0.5 text-sm font-medium rounded-full ${perc < 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'}`}>
            %{Math.floor(Math.abs(perc))}
            {perc < 0 ? (
              <ArrowDownward className="w-5 h-5" />
            ) : (
              <ArrowUpward className="w-5 h-5" />
            )}
          </span>
        </div>
        <span className="text-sm mt-2">Compared to last month</span>
      </div>
      <div style={{boxShadow: "rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset"}} className="p-6 bg-orange-500 rounded-lg shadow-md text-white">
        <div className="flex items-center justify-between">
        <span className="text-sm font-medium uppercase">Shipped</span>
          <FaMoneyBillWave className="w-6 h-6" />
        </div>
        <div  className="flex items-center mt-2">
          <span className="text-3xl font-semibold">${income}</span>
          <span className={`ml-2 px-2.5 py-0.5 text-sm font-medium rounded-full ${perc < 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'}`}>
            %{Math.floor(Math.abs(perc))}
            {perc < 0 ? (
              <ArrowDownward className="w-5 h-5" />
            ) : (
              <ArrowUpward className="w-5 h-5" />
            )}
          </span>
        </div>
        <span className="text-sm mt-2">Compared to last month</span>
      </div>
      <div style={{boxShadow: "rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset"}} className="p-6 bg-purple-700 rounded-lg shadow-md text-white">
        <div className="flex items-center justify-between">
          <span className="text-sm font-medium uppercase">Delivered</span>
          <FaDollarSign className="w-6 h-6" />
        </div>
        <div className="flex items-center mt-2">
          <span className="text-3xl font-semibold">0</span>
          <span className="ml-2 px-2.5 py-0.5 text-sm font-medium rounded-full bg-green-100 text-green-800">
    -1.4 <ArrowDownward className="w-5 h-5" />
    </span>
  </div>
  <span className="text-sm mt-2">Compared to last month</span>
</div>
</div>
  )}