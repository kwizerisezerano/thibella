
export function formatCurrency(amount: number, currency: string = "USD"){
   const formattedPrice = new Intl.NumberFormat(undefined,{
    style: "currency",
    currency: currency,
    minimumFractionDigits: 2,
   // maximumFractionDigits: 10,
  }).format(amount);

  return currency === "RWF" ? `${formattedPrice.replace("RWF", "").trim()} RWF` : formattedPrice;
  
}