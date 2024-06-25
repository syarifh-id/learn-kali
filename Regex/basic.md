# BASIC

## | alternation

/a|b/ => a or b

## () group

/eat(noodle|rice)/ => eat noodle or eat rice

## [] character set

/[abc]/ => a,b or c
/[0-9]/ => any number 0 to 9
/[A-EG-Z]/ => capital alphabet except F
/[0-9][0-9]/ => 01,02,03,...,97,98,99 (combination)
/[123][0-9]/ => 10,11,12,13,14,...,38,39

## ^ Negation

/[^a-z]/ Not a to z

## quantifier

/X{n}/ X in a row as many as n
/X{n,m}/ X in a row as many min n max m

## ? optional

## . dot

## \* loop

## ^ $ anchor

# MODIFIER

## i case insensitive

## s single line

## m multi line

## g global
