SELECT DISTINCT count(distinct NobelPrizes.awardYear) + 3 FROM NobelPrizes, LaureatePrizes, Organizations
WHERE LaureatePrizes.prizeId = NobelPrizes.id AND LaureatePrizes.laurId = Organizations.id
ORDER BY 1;